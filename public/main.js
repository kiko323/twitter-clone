
deletePost= document.getElementById('delete-post');

if(deletePost)
{
    deletePost.addEventListener('click', e => {
        if(e.target.className === 'btn btn-danger delete-post')
    {

        const id=e.target.getAttribute('data-id');
        console.log(id);
    }

});
}