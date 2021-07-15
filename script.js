let postItems = document.querySelectorAll('.post-item');
console.log(postItems);
postItems.forEach(function (item, i) {
    let commentItems = item.querySelectorAll('.comment-item');
    commentItems.forEach(function (item2, i2) {
        if (i2 == 0) {
            item2.style.display = 'block';
        } else {
            item2.style.display = 'none';
        }
    });

    let btnReadMore = document.createElement('button');

    btnReadMore.innerHTML = 'Read More';
    btnReadMore.classList = 'btn-read-more';
    item.querySelector('.comments').appendChild(btnReadMore);


    btnReadMore.addEventListener('click', function () {
        commentItems.forEach(function (item2, i2) {

            if (item2.style.display == 'block' && i2 != 0) {
                item2.style.display = 'none';
            } else {
                item2.style.display = 'block';
            }

        });
    });
});





