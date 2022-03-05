let likeBtn = document.querySelector('.likeBtn');

const likeBtnIcon = document.querySelector('.likeBtnIcon');

likeBtn.addEventListener('click', function(){

    event.preventDefault();

    if(likeBtnIcon.classList.contains('inactive')){
        console.log('active');     
        likeBtnIcon.classList.remove('inactive');
        likeBtnIcon.classList.add('active');


        let endpoint = "api/api-favorite.php";
              fetch(endpoint)
                .then(res => res.text())
                .then(function(favorite) {
                  console.log(favorite);
                  console.log('a favorite is made');
                  likeBtn.querySelector('p').innerText = "It's a favorite";
                  console.log(likeBtn);
                  likeBtn.classList.add('grid-almost-two');
                  likeBtn.classList.remove('grid-two-thirds-reversed');
                  
                });
    }
    else if(likeBtnIcon.classList.contains('active')){
        console.log('inactive');
        likeBtnIcon.classList.remove('active');
        likeBtnIcon.classList.add('inactive');

        let endpoint = "api/api-unfavorite.php";
              fetch(endpoint)
                .then(res => res.text())
                .then(function(favorite) {
                  console.log(favorite);
                  likeBtn.querySelector('p').innerText = "Add to favorites";
                  console.log(likeBtn);
                  likeBtn.classList.remove('grid-almost-two');
                  likeBtn.classList.add('grid-two-thirds-reversed');
                });
    }
    
    })
    
    