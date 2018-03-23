deletePost= document.getElementById('delete-post');

if(deletePost)
{
    deletePost.addEventListener('click', e => {
        if(e.target.className == 'btn btn-danger delete-post')
    {
        if(confirm('Are you sure you want to delete it? '))
        {
            const id=e.target.getAttribute('data-id');
            alert(id);
        }
    }

    });
}