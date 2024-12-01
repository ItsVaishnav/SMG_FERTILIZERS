// function toggleSidebar() {
//     const sidebar = document.getElementById('sidebar');
//     const overlay = document.createElement('div');
//     overlay.classList.add('overlay');
    
//     if (!sidebar.classList.contains('active')) {
//         sidebar.classList.add('active');
//         document.body.appendChild(overlay);
//         overlay.addEventListener('click', () => {
//             sidebar.classList.remove('active');
//             document.body.removeChild(overlay);
//         });
//     } else {
//         console.log("is Clicked");
//         sidebar.classList.remove('active');
//         if (document.querySelector('.overlay')) {
//             document.body.removeChild(document.querySelector('.overlay'));
//         }
//     }
//     sidebar.style.width = sidebar.style.width === '60px' ? '250px' : '60px';
// }



// function toggleSidebar() {
//     const sidebar = document.getElementById('sidebar');
//     const overlay = document.querySelector('.overlay');

//     // Check if overlay already exists; if not, create it
//     if (!overlay) {
//         const newOverlay = document.createElement('div');
//         // newOverlay.classList.add('overlay');
//         newOverlay.addEventListener('click', () => {
//             sidebar.classList.remove('active');
//             newOverlay.classList.remove('visible');
//             document.body.appendChild(newOverlay);
//         });
//         document.body.appendChild(newOverlay);
//     }

//     // Toggle sidebar visibility
//     sidebar.classList.toggle('active');

//     // Toggle overlay visibility
//     if (sidebar.classList.contains('active')) {
//         document.querySelector('.overlay').classList.add('visible');
//     } else {
//         document.querySelector('.overlay').classList.remove('visible');
//     }
// }

console.log("Script");
function toggleSidebar() {
    const sidebar = document.getElementById('sidebar');
    const overlay = document.querySelector('.overlay');

    // Check if overlay already exists; if not, create it
    if (!overlay) {
        const newOverlay = document.createElement('div');
        newOverlay.classList.add('overlay');
        newOverlay.addEventListener('click', closeSidebar); // Close sidebar on overlay click
        document.body.appendChild(newOverlay);
    }

    // Toggle the sidebar visibility
    sidebar.classList.toggle('active');

    // Show overlay only on smaller screens (up to 768px)
    if (window.innerWidth <= 768) {
        document.querySelector('.overlay').classList.toggle('visible');
    }
}

function closeSidebar() {
    const sidebar = document.getElementById('sidebar');
    const overlay = document.querySelector('.overlay');

    // Hide the sidebar and overlay
    sidebar.classList.remove('active');
    if (overlay) {
        overlay.classList.remove('visible');
    }
}

// Automatically close sidebar when clicking on a link
document.querySelectorAll('.nav-list li a').forEach(link => {
    link.addEventListener('click', closeSidebar);
});
