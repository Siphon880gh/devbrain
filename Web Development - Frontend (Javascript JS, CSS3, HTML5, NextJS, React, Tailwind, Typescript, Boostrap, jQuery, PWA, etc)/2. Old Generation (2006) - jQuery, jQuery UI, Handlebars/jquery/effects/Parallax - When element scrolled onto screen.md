Parallax - Fade in / fade out an element when a reference element appears on screen

Considering that the user is scrolling and you have a reference element that will trigger an animation or another element to appear once that reference element is scrolled onto the screen:

 - windowY is the scrolling position of the document. 
 - elY is the scrolling position of the reference element

            setInterval(()=>{
                var windowY = parseInt($(document).scrollTop()) + $(window).height();
                var elY = $("#if-you-see-me")[0].getBoundingClientRect().y;
                if(elY<windowY) {
                    $("#then-I-will-appear").fadeIn(500);
                } else {
                    $("#then-I-will-appear").fadeOut(500);
                }
            }, 200)
