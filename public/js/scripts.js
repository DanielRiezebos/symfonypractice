function vote(id, direction)
{
    $.ajax({
        url: 'blog/vote/'+id+'/'+direction,
        type: 'POST',
        success: function (result) {
            console.log($('#vote-block-'+id+' > h3').html(result));
        },
        error: function (result) {
            console.log(result)
        }
    })
}