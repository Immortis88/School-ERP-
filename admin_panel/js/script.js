const allSideMenu = document.querySelectorAll('.sidebar .side-menu li a');
const currentPage = window.location.pathname;

allSideMenu.forEach(item=>{
    const li = item.parentElement;

    li.classList.remove('active');

    if (item.getAttribute("href") && currentPage.includes(item.getAttribute("href"))) {
        li.classList.add('active');
    }

    item.addEventListener('click',function() {
        allSideMenu.forEach(i => {i.parentElement.classList.remove('active')});
        li.classList.add('active');
    });
});
 

//toggle bar
const menuBar = document.querySelector('.navbar .bar a i.bx.bx-menu.fs-3');
const sidebar = document.querySelector('.sidebar');

menuBar.addEventListener('click',function(e){
    e.preventDefault(); 
    sidebar.classList.toggle('hide');
})


if(window.innerWidth < 768){
    sidebar.classList.add('hide');
}





// function showToast(message) {
//       const toastBody = document.getElementById('toast-alert-message');
//       const toastElement = document.getElementById('liveToast');
//       toastBody.textContent = message;
//       const toast = new bootstrap.Toast(toastElement, {
//         animation: true,
//         autohide: true,
//         delay: 5000
//       });
//       toast.show();
//     }
// // Dynamic Toast JavaScript 
//     document.addEventListener('DOMContentLoaded', () => {
//       const button = document.getElementById('triggerToast');
//       if (button) {
//         button.addEventListener('click', () => {
//           showToast('Successfully Logined!');
//         });
//       }
//     });


