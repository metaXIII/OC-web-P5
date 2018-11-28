function loadCarousel() {
    /**
     * Permet de rajouter la navigation au tactile pour le carousel
     */
    class CarouselTouchPlugin {
        /**
         * @param {Carousel} carousel
         */
        constructor(carousel) {
            carousel.container.addEventListener('dragstart', e => e.preventDefault())
            carousel.container.addEventListener("mousedown", this.startDrag.bind(this))
            carousel.container.addEventListener("touchstart", this.startDrag.bind(this))
            window.addEventListener('mousemove', this.drag.bind(this))
            window.addEventListener('touchmove', this.drag.bind(this))
            window.addEventListener('touchend', this.endDrag.bind(this))
            window.addEventListener('mouseup', this.endDrag.bind(this))
            window.addEventListener('touchcancel', this.endDrag.bind(this))
            this.carousel = carousel
        }

        /**
         * Démare le déplacement au toucher
         * @param {MouseEvent|TouchEvent} e
         */
        startDrag(e) {
            if (e.touches) {
                if (e.touches.length > 1) {
                    return
                } else {
                    e = e.touches[0]
                }
            }
            this.origin = {x: e.screenX, y: e.screenY}
            this.width = this.carousel.containerWidth
            this.carousel.disableTransition()
        }

        /**
         * déplacement
         * @param {MouseEvent|TouchEvent} e
         */
        drag(e) {
            if (this.origin) {
                let point = e.touches ? e.touches[0] : e
                let translate = {x: point.screenX - this.origin.x, y: point.screenY - this.origin.y}
                if (e.touches && Math.abs(translate.x) > Math.abs(translate.y)) {
                    e.preventDefault()
                    e.stopPropagation()
                } else if (e.touches) {
                    return
                }
                let baseTranslate = this.carousel.currentItem * -100 / this.carousel.items.length
                this.lastTranslate = translate
                this.carousel.translate(baseTranslate + 100 * translate.x / this.width)
            }
        }

        /**
         * Fin du déplacement
         * @param {MouseEvent|TouchEvent} e
         */
        endDrag(e) {
            if (this.origin && this.lastTranslate) {
                this.carousel.enableTransition()
                if (Math.abs(this.lastTranslate.x / this.carousel.carouselWidth) > 0.2) {
                    if (this.lastTranslate.x < 0) {
                        this.carousel.next()
                    } else {
                        this.carousel.prev()
                    }
                } else {
                    this.carousel.goToItem(this.carousel.currentItem)
                }
            }
            this.origin = null
        }

    }

    class Carousel {
        /**
         * This callback type is called `requestCallback` and is displayed as a global symbol.
         * @callback moveCallback
         * @param {number} index
         */
        /**
         * @param {HTMLElement} element
         * @param {Object} options
         * @param {Object} [options.slidesToScroll=1] permet de préciser le nombre d'élément à faire défiler
         * @param {Object} [options.slidesVisible=1] Nombre d'élément visible dans un slide
         * @param {boolean} [options.loop=false] Doit on boucler en fin de carousel
         * @param {boolean} [options.pagination=false] Mettre en place une pagination ou non
         * @param {boolean} [options.navigation=true] Mettre en place une navigation ou non
         * @param {boolean} [options.infinite=false] Défilement infini
         */
        constructor(element, options = {}) {
            this.element = element
            this.options = Object.assign({}, {
                slidesToScroll: 1,
                slidesVisible: 1,
                loop: false,
                pagination: false,
                navigation: true,
                infinite: false,
                autoSlide: false
            }, options)
            if (this.options.loop && this.options.infinite) {
                throw new Error('Un caroussel ne peut être à la fois en boucle et en infini')
            }
            let children = [].slice.call(element.children)
            this.isMobile = false
            this.currentItem = 0
            this.moveCallbacks = []
            this.offset = 0
            let animate = null

            //Modification du DOM
            this.root = this.createDivWithClass('carousel')
            this.container = this.createDivWithClass('carousel__container')
            this.root.setAttribute('tabindex', '0')
            this.root.appendChild(this.container)
            this.element.appendChild(this.root)
            this.items = children.map((child) => {
                let item = this.createDivWithClass('carousel__item')
                item.appendChild(child)
                return item
            })
            if (this.options.infinite) {
                this.offset = this.options.slidesVisible + this.options.slidesToScroll
                if (this.offset > children.length) {
                    console.error("Vous n'avez pas assez d'éléments dans le caroussel", element)
                }
                this.items = [
                    ...this.items.slice(this.items.length - this.offset).map(item => item.cloneNode(true)),
                    ...this.items,
                    ...this.items.slice(0, this.offset).map(item => item.cloneNode(true)),
                ]
                this.goToItem(this.offset, false)
            }
            this.items.forEach(item => this.container.appendChild(item))
            this.setStyle()
            if (this.options.navigation === true) {
                this.createNavigation()
            }
            if (this.options.pagination === true) {
                this.createPagination()
            }
            if (this.options.autoSlide === true) {
                animate = this.animateSlide()
            }
            //Evènements
            this.moveCallbacks.forEach(cb => cb(this.currentItem))
            this.onWindowResize()
            window.addEventListener('resize', this.onWindowResize.bind(this))
            window.addEventListener('keyup', e => {
                if (e.key === "ArrowRight" || e.key === "Right")
                    this.next()
                else if (e.key === "ArrowLeft" || e.key === "Left")
                    this.prev()
            })
            if (this.options.infinite)
                this.container.addEventListener('transitionend', this.resetInfinite.bind(this))
            new CarouselTouchPlugin(this)
            let pause = document.getElementById("pause")
            pause.addEventListener("click", () => {
                if (this.options.autoSlide === true) {
                    this.createDivHelp()
                    this.options.autoSlide = false
                    clearInterval(animate)
                    pause.classList.remove("fa-pause-circle")
                    pause.classList.add("fa-play-circle")
                } else {
                    this.createDivHelp()
                    this.options.autoSlide = true
                    animate = this.animateSlide()
                    pause.classList.add("fa-pause-circle")
                    pause.classList.remove("fa-play-circle")
                }
            })
        }

        /**
         *
         * @return {event} Permet de retourner un interval de répétition pour passer à la slide suivante
         */
        animateSlide() {
            return setInterval(() => {
                this.next()
            }, 10000)
        }

        /**
         * Applique les bonnes dimensions
         * aux éléments du caroussel
         */
        setStyle() {
            let ratio = this.items.length / this.slidesVisible
            this.container.style.width = (ratio * 100) + "%"
            this.items.forEach(item => item.style.width = ((100 / this.slidesVisible) / ratio) + "%")
        }

        /**
         * Permet la navigation du caroussel
         */
        createNavigation() {
            let nextButton = this.createDivWithClass('carousel__next')
            let prevButton = this.createDivWithClass('carousel__prev')
            this.root.appendChild(nextButton)
            this.root.appendChild(prevButton)
            nextButton.addEventListener("click", this.next.bind(this))
            prevButton.addEventListener("click", this.prev.bind(this))
            if (this.options.loop === true) {
                return
            }
            this.onMove(index => {
                if (index === 0) {
                    prevButton.classList.add('carousel__prev--hidden')
                }
                else {
                    prevButton.classList.remove('carousel__prev--hidden')
                }
                if (this.items[this.currentItem + this.slidesVisible] === undefined) {
                    nextButton.classList.add('carousel__next--hidden')
                }
                else {
                    nextButton.classList.remove('carousel__next--hidden')
                }
            })
        }

        /**
         * Permet la pagination du caroussel dans le DOM
         */
        createPagination() {
            let pagination = this.createDivWithClass('carousel__pagination')
            let buttons = []
            this.root.appendChild(pagination)
            for (let i = 0; i < this.items.length - 2 * this.offset; i = i + this.options.slidesToScroll) {
                let button = this.createDivWithClass('carousel__pagination__button')
                button.addEventListener('click', () => this.goToItem(i + this.offset))
                pagination.appendChild(button)
                buttons.push(button)
            }
            this.onMove(index => {
                let count = this.items.length - 2 * this.offset
                let activeButton = buttons[Math.floor(((index - this.offset) % count) / this.options.slidesToScroll)]
                if (activeButton) {
                    buttons.forEach(button => button.classList.remove('carousel__pagination__button--active'))
                    activeButton.classList.add('carousel__pagination__button--active')
                }
            })
            let pause = this.createDivWithClass("far fa-pause-circle")
            pause.setAttribute("id", "pause")
            pagination.appendChild(pause)
        }

        /**
         * return div pour afficher l'état du Slider, arrété ou non.
         */
        createDivHelp() {
            if (this.options.autoSlide) {
                let el = this.createDivWithClass("alert alert-primary")
                el.textContent = "Pause du slider"
                if (document.getElementById("indicate").hasChildNodes())
                    document.getElementById("indicate").removeChild(document.getElementById("indicate").childNodes[0])
                document.getElementById("indicate").appendChild(el)
            } else {
                let el = this.createDivWithClass("alert alert-success")
                el.textContent = "Reprise du slider"
                document.getElementById("indicate").removeChild(document.getElementById("indicate").childNodes[0])
                document.getElementById("indicate").appendChild(el)
            }
        }

        translate(percent) {
            this.container.style.transform = 'translate3d(' + percent + '%, 0, 0)'
        }

        next() {
            this.goToItem(this.currentItem + this.slidesToScroll)
        }

        prev() {
            this.goToItem(this.currentItem - this.slidesToScroll)
        }

        /**
         * Déplace le slider vers l'élément cible
         * @param {number} index
         * @param {boolean} [animation = true]
         */
        goToItem(index, animation = true) {
            if (index < 0) {
                if (this.options.loop) {
                    index = this.items.length - this.options.slidesVisible
                }
                else {
                    return
                }
            } else if (index >= this.items.length || (this.items[this.currentItem + this.slidesVisible] === undefined
                && index > this.currentItem)) {
                if (this.options.loop) {
                    index = 0
                }
                else
                    return
            }
            let translateX = index * -100 / this.items.length
            if (animation === false)
                this.disableTransition()
            this.translate(translateX)
            this.container.offsetHeight // force le navigateur à faire un repeint
            if (animation === false) {
                this.enableTransition()
            }
            this.currentItem = index
            this.moveCallbacks.forEach(cb => cb(index))
        }

        /**
         * Déplace le slide pour donner l'impression d'un slide infini
         */
        resetInfinite() {
            if (this.currentItem <= this.options.slidesToScroll) {
                this.goToItem(this.currentItem + (this.items.length - 2 * this.offset), false)
            } else if (this.currentItem >= this.items.length - this.offset) {
                this.goToItem(this.currentItem - (this.items.length - 2 * this.offset), false)
            }
        }

        /**
         * @param {moveCallback} cb
         */
        onMove(cb) {
            this.moveCallbacks.push(cb)
        }

        onWindowResize() {
            let mobile = window.innerWidth < 800
            if (mobile !== this.isMobile) {
                this.isMobile = mobile
                this.setStyle()
                this.moveCallbacks.forEach(cb => cb(this.currentItem))
            }
        }

        /**
         * @param {string} className
         * @returns {HTMLElement}
         */
        createDivWithClass(className) {
            let div = document.createElement('div')
            div.setAttribute('class', className)
            return div
        }

        disableTransition() {
            this.container.style.transition = 'none'
        }

        enableTransition() {
            this.container.style.transition = ''
        }

        /**
         * @return {number}
         */
        get slidesToScroll() {
            return this.isMobile ? 1 : this.options.slidesToScroll
        }

        /**
         * @return {number}
         */
        get slidesVisible() {
            return this.isMobile ? 1 : this.options.slidesVisible
        }

        /**
         * @return {number}
         */
        get containerWidth() {
            return this.container.offsetWidth
        }

        /**
         * @return {number}
         */
        get carouselWidth() {
            return this.root.offsetWidth
        }
    }

    //Création du Carousel
    new Carousel(document.querySelector('#carousel'), {
        slidesToScroll: 1,
        pagination: true,
        infinite: true,
        autoSlide: false
    })
}


//Permet de lancer le caroussel uniquement que lorsque le contenu de toute la page est chargée
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', loadCarousel)
} else {
    loadCarousel()
}
