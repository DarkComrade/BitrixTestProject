$(document).ready(function () {
    $('button.sendVote').click(function () {
        let postId = $(this).data('post');
        BX.ajax.runComponentAction('msoft:posts.votes', 'add', {
            data : {
                fields: {
                    POST_ID: postId
                }
            }
        }).then(function (response)  {
            if(response.data['status'] == true) {
                postId = response.data['postId'];
                $(".isVoted[data-post="+postId+"]").removeClass("nonActive");
                $(".sendVote[data-post="+postId+"]").addClass("nonActive");

            }
        })
    })
});