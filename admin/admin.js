const deleteButtons = document.querySelectorAll(".delete-button");

deleteButtons.forEach(button => {
    button.addEventListener("click", () => {
        const id = button.dataset.id;

        if (confirm("Are you sure you want to delete this user?")) {
            fetch(`delete-user.php?id=${id}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    } else {
                        alert(data.message);
                    }
                })
                .catch(error => console.error(error));
        }
    });
});
  
