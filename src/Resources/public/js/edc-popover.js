function goToEdcUrl(url) {
    window.open(url, 'edc-help', 'scrollbars=1,resizable=1,height=800,width=1200');
}

function configureEdcPopover(rel, placement, trigger, animation, container, delay_show, delay_hide, label, contentPopoverId) {
    $('[rel="' + rel + '"]').popover({
        html: true,
        placement: placement,
        trigger: trigger,
        animation: (animation === 1),
        container: container,
        boundary: 'window',
        delay: {'show': delay_show, 'hide': delay_hide},
        title: label,
        content: function () {
            return $('#' + contentPopoverId).html();
        }
    });
}


