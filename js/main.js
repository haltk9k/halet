function updateDates() {
    const dateElements = document.querySelectorAll('.current-date');
    const timeElements = document.querySelectorAll('.current-time');
    const yearElement = document.querySelector('#current-year');
    
    const currentDate = new Date();
    const formattedDate = currentDate.toLocaleDateString();
    const formattedTime = currentDate.toLocaleTimeString();
    const currentYear = currentDate.getFullYear();
    
    dateElements.forEach(el => el.textContent = formattedDate);
    timeElements.forEach(el => el.textContent = formattedTime);
    if (yearElement) yearElement.textContent = currentYear;
}

window.onload = updateDates;
