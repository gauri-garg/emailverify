const togglebtn = document.getElementById('toggle-btn')
const sidebar = document.getElementById('sidebar')

function ToggleMenu(button)
{
    button.nextElementSibling.classList.toggle('show')
    button.classList.toggle('rotate')
    
    if(sidebar.classList.contains('close'))
    {
    sidebar.classList.toggle('close')
    togglebtn.classList.toggle('rotate')
    }
}
function toggleSidebar(){
    sidebar.classList.toggle('close');
    togglebtn.classList.toggle('rotate')
    Array.from(sidebar.getElementsByClassName('show')).forEach(ul=> 
        {ul.classList.remove('show')
        ul.previousElementSibling.classList.remove})
}
