export default function(message, type, animation) {
    return `<div class="alert alert-custom alert-custom--${type} alert-dismissible ${animation ? animation : 'alert-slideInLeft'}" role="alert">
        <div class="alert-custom__icon">
            <i class="fas fa-check-circle icon"></i>
        </div>
        <div class="alert-custom__content">
            <p>${message}</p>
        </div>
        <div class="alert-custom__close">
            <button type="button" class="btn-close" data-dismiss="alert" aria-label="Close"><i class="far fa-times-circle icon"></i></button>
        </div>
    </div>`
}

