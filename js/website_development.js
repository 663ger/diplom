function navopen(){
    document.querySelector('.nav').classList.toggle('active');
}
function backcall(){
    document.querySelector('.full_popup_backcall').classList.toggle('active');
    document.querySelector('.popup_backcall').classList.toggle('active');
}
function scrollToElement(id) {
    var element = document.getElementById(id);
    if (element) {
        element.scrollIntoView({ behavior: "smooth", block: "start", inline: "nearest" });
    }
}
