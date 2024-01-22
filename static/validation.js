document.getElementById('input').addEventListener('input', function () {
    var currLength = this.value.length;
    var maxLength = parseInt(this.getAttribute('maxlength'));
    var remainingChars = maxLength - currLength;
    document.getElementById('char_count').textContent = remainingChars;

    // Truncate the input if exceeding limit
    if (currLength > maxLength) {
        this.value = this.value.substring(0, maxLength);
    }
});