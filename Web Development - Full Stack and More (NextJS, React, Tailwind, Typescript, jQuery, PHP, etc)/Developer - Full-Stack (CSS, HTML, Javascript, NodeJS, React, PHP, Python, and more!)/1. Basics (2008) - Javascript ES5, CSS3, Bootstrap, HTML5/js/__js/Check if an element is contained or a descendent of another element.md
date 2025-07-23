

document.querySelector("#info-box").contains(document.querySelector("#app"))
// false


document.querySelector("#app").contains(document.querySelector("#info-box"))
// flase

So:
el1.contains(el2)