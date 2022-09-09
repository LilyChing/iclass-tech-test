function tooltip(e){
    // use currentTarget and firstElementChild to point at <span class="tooltip">
    var tooltipPos = e.currentTarget.firstElementChild;
        tooltipPos.style.left = e.pageX + 'px';
        tooltipPos.style.top = e.pageY + 'px';
}
