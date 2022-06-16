window.onload = () => {
    let links = document.querySelectorAll("[data-delete]")
    links.forEach(link => {
        link.addEventListener('click', function (e) {
            e.preventDefault()

            if (confirm("T'es sûr de toi ?!")) {
                fetch(this.getAttribute('href'), {
                    method: 'DELETE',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({'_token': this.dataset.token})
                }).then(
                    res => res.json()
                ).then(data => {
                    if (data.success) {
                        this.parentElement.remove()
                    } else {
                        alert(data.error)
                    }
                })
            }
        })
    })
}