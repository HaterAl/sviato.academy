import VPlayer from '@vimeo/player'

(() => {
    const openEls = document.querySelectorAll('[data-player-open]')
    const playerEl = document.querySelector('[data-player')
    let player = null

    if (!playerEl || !openEls.length) {
        return
    }

    const innerEl = playerEl.querySelector('[data-player-inner')
    const closeEl = playerEl.querySelector('[data-player-close')

    openEls.forEach(openEl => {
        openEl.addEventListener('click', async e => {
            e.preventDefault()

            const videoId = openEl.dataset.playerOpen

            if (!videoId) {
                return
            }

            document.documentElement.classList.add('is-player-open')

            if (player) {
                const oldVideoId = await player.getVideoId()

                if (`${oldVideoId}` !== `${videoId}`) {
                    await player.loadVideo(videoId)
                }
            } else {
                player = new VPlayer(innerEl, {
                    id: videoId,
                    color: 'ffda55',
                })
            }

            player.play()
        }, false)
    })

    closeEl.addEventListener('click', e => {
        e.preventDefault()

        player.pause()
        player.setCurrentTime(0)
        document.documentElement.classList.remove('is-player-open')
    }, false)

})()
