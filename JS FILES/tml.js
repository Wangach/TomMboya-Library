//Navigation bar
let navbar = document.querySelector(".header .navbar");
document.querySelector("#menu-btn").onclick = () =>{
    navbar.classList.add("active");
}

document.querySelector("#nav-close").onclick = () =>{
    navbar.classList.remove("active");
}

window.onscroll = () =>{
    navbar.classList.remove("active");
}

//Navigation bar effect on scroll
window.addEventListener("scroll",function(){
    const header = document.querySelector("header");
    header.classList.toggle("sticky", window.scrollY > 0);
});

