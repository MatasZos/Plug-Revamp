function toggleDropdown() {
    const dropdown = document.getElementById("dropdown");
    dropdown.classList.toggle("active");
}

// Close dropdown if clicking outside
window.addEventListener("click", function(event) {
    const profile = document.querySelector(".nav-profile");
    const dropdown = document.getElementById("dropdown");

    if (!profile.contains(event.target)) {
        dropdown.classList.remove("active");
    }
});
