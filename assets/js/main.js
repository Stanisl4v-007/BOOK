
document.addEventListener('DOMContentLoaded', function() {
    
    
    const messages = document.querySelectorAll('.message');
    messages.forEach(msg => {
        setTimeout(() => {
            msg.style.transition = 'opacity 0.3s';
            msg.style.opacity = '0';
            setTimeout(() => msg.remove(), 300);
        }, 5000);
    });

    
    const deleteLinks = document.querySelectorAll('.btn-danger');
    deleteLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            if (!confirm('Вы уверены, что хотите удалить эту книгу?')) {
                e.preventDefault();
            }
        });
    });

});