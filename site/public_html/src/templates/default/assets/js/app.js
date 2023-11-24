const videoLinks = document.querySelectorAll('.video')
videoLinks.forEach(videoLink => {
    videoLink.onclick = () => {
        let options = {
            method: 'GET',
            headers: {}
        };

        var url = '/checkVideo?id=' + videoLink.getAttribute('id');

        fetch(url, options)
            .then(response => response.json())
            .then(body => {
                if(body.is_processed == 0){
                    alert('Видео в обработке');

                    window.location.href = '/';
                } else {
                    window.location.href = '/video?id=' + videoLink.getAttribute('id');
                }
            });

        window.location.href = '/';
        return false;
    }
})
