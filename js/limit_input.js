function limitInputLength(element, digits) {
    let value = element.value.toString().replace(/\D/g, '');
    if (value.length > digits) {
      value = value.substring(0, digits);
    }
    element.value = value;

    let cardIcon = document.getElementById('card-icon');
    if (value.startsWith('4')) {
      cardIcon.className = 'card-icon visa';
    } else if (value.startsWith('5')) {
      cardIcon.className = 'card-icon mastercard';
    } else {
      cardIcon.className = 'card-icon default-icon';
    }
}