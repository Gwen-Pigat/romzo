

//Resize dynamique (peut servir si le menu est fixed)
const resizeContent = () => {
    console.log(document.body)
    //document.body.css.height = window.innerHeight+"px"
}
resizeContent()
window.addEventListener('resize', function(event) {
    resizeContent()
}, true);
