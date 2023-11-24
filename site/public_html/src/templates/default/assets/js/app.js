const videoLinks = document.querySelectorAll('.video')
videoLinks.forEach(videoLink => {
    videoLink.onclick = () => {
        let options = {
            method: 'GET',
            headers: {}
        };

        fetch('/get-data', options)
            .then(response => response.json())
            .then(body => {
                console.log(body)
            });
        if(videoLink.getAttribute('data-process') == 1){
            alert('Видео в обработке');
            return false;
        }
    }
})
