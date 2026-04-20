// Initialisation des composants
document.addEventListener('DOMContentLoaded', function() {
    // Tooltips
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function(tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
    
    // Popovers
    const popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
    popoverTriggerList.map(function(popoverTriggerEl) {
        return new bootstrap.Popover(popoverTriggerEl);
    });
    
    // Toasts
    const toastElList = [].slice.call(document.querySelectorAll('.toast'));
    const toastList = toastElList.map(function(toastEl) {
        return new bootstrap.Toast(toastEl);
    });
    
    // Auto-show toasts
    toastList.forEach(toast => toast.show());
    
    // Initialiser les datepickers
    initDatePickers();
    
    // Initialiser les select2
    initSelect2();
    
    // Initialiser les DataTables
    initDataTables();
    
    // Gestion des formulaires
    initForms();
    
    // Gestion des notifications
    initNotifications();
});

// Datepickers
function initDatePickers() {
    // Déjà initialisé dans le layout principal
}

// Select2
function initSelect2() {
    // Déjà initialisé dans le layout principal
}

// DataTables
function initDataTables() {
    $('.datatable').DataTable({
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.4/i18n/fr-FR.json'
        },
        pageLength: 25,
        lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Tous"]],
        responsive: true,
        order: [],
        columnDefs: [
            { orderable: false, targets: 'no-sort' }
        ]
    });
}

// Formulaires
function initForms() {
    // Confirmation avant suppression with click handler
    $(document).on('click', '.delete-confirm', function(e) {
        e.preventDefault();
        const form = $(this).closest('form');
        
        Swal.fire({
            title: 'Êtes-vous sûr ?',
            text: "Cette action est irréversible !",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Oui, supprimer',
            cancelButtonText: 'Annuler'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    });
    
    // Afficher/masquer les champs conditionnels
    $('.conditional-field').each(function() {
        const target = $(this).data('target');
        const value = $(this).data('value');
        const field = $(this);
        
        field.on('change', function() {
            if ($(this).val() == value) {
                $(target).slideDown();
            } else {
                $(target).slideUp();
            }
        });
        
        // Déclencher au chargement
        field.trigger('change');
    });
}

// Notifications
function initNotifications() {
    // Marquer une notification comme lue
    $('.mark-as-read').on('click', function(e) {
        e.preventDefault();
        const url = $(this).data('url');
        const notification = $(this).closest('.notification-item');
        
        $.ajax({
            url: url,
            method: 'POST',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function() {
                notification.fadeOut(300, function() {
                    $(this).remove();
                    updateNotificationCount();
                });
            }
        });
    });
    
    // Marquer toutes comme lues
    $('#mark-all-read').on('click', function(e) {
        e.preventDefault();
        const url = $(this).data('url');
        
        $.ajax({
            url: url,
            method: 'POST',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function() {
                $('.notification-item').fadeOut(300, function() {
                    $(this).remove();
                    updateNotificationCount();
                });
            }
        });
    });
    
    // Mettre à jour le compteur de notifications
    function updateNotificationCount() {
        const count = $('.notification-item').length;
        $('.notification-count').text(count);
        
        if (count === 0) {
            $('.notification-count').hide();
        } else {
            $('.notification-count').show();
        }
    }
}

// Fonctions utilitaires
function formatBytes(bytes, decimals = 2) {
    if (bytes === 0) return '0 Bytes';
    
    const k = 1024;
    const dm = decimals < 0 ? 0 : decimals;
    const sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB'];
    
    const i = Math.floor(Math.log(bytes) / Math.log(k));
    
    return parseFloat((bytes / Math.pow(k, i)).toFixed(dm)) + ' ' + sizes[i];
}

function formatDate(date) {
    return new Date(date).toLocaleDateString('fr-FR', {
        year: 'numeric',
        month: 'long',
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
    });
}

function formatRelativeTime(date) {
    const now = new Date();
    const diff = now - new Date(date);
    
    const minute = 60 * 1000;
    const hour = minute * 60;
    const day = hour * 24;
    const week = day * 7;
    const month = day * 30;
    const year = day * 365;
    
    if (diff < minute) {
        return 'À l\'instant';
    } else if (diff < hour) {
        const minutes = Math.floor(diff / minute);
        return `Il y a ${minutes} minute${minutes > 1 ? 's' : ''}`;
    } else if (diff < day) {
        const hours = Math.floor(diff / hour);
        return `Il y a ${hours} heure${hours > 1 ? 's' : ''}`;
    } else if (diff < week) {
        const days = Math.floor(diff / day);
        return `Il y a ${days} jour${days > 1 ? 's' : ''}`;
    } else if (diff < month) {
        const weeks = Math.floor(diff / week);
        return `Il y a ${weeks} semaine${weeks > 1 ? 's' : ''}`;
    } else if (diff < year) {
        const months = Math.floor(diff / month);
        return `Il y a ${months} mois`;
    } else {
        const years = Math.floor(diff / year);
        return `Il y a ${years} an${years > 1 ? 's' : ''}`;
    }
}

// Export de fonctions globales
window.confirmDelete = function(event, message) {
    event.preventDefault();
    Swal.fire({
        title: 'Confirmation',
        text: message || 'Êtes-vous sûr de vouloir supprimer cet élément ?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Oui, supprimer',
        cancelButtonText: 'Annuler'
    }).then((result) => {
        if (result.isConfirmed) {
            if (event.target.form) {
                event.target.form.submit();
            } else if (event.target.href) {
                window.location.href = event.target.href;
            }
        }
    });
};

window.showSuccess = function(message) {
    Swal.fire({
        icon: 'success',
        title: 'Succès',
        text: message,
        timer: 3000,
        showConfirmButton: false
    });
};

window.showError = function(message) {
    Swal.fire({
        icon: 'error',
        title: 'Erreur',
        text: message
    });
};

window.showLoading = function() {
    Swal.fire({
        title: 'Chargement...',
        allowOutsideClick: false,
        showConfirmButton: false,
        willOpen: () => {
            Swal.showLoading();
        }
    });
};

window.hideLoading = function() {
    Swal.close();
};