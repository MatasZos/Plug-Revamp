document.addEventListener("DOMContentLoaded", () => {
    const delivery = document.getElementById('delivery-method');
    const paymentSelect = document.getElementById('payment-method');
    const cardInfo = document.getElementById('card-info');

    const updatePaymentUI = () => {
        const deliveryType = delivery.value;

        if (deliveryType === 'pickup') {
            paymentSelect.innerHTML = `
                <option value="Pay at counter">Pay at counter</option>
                <option value="Visa">Visa</option>
                <option value="MasterCard">MasterCard</option>
                <option value="Revolut">Revolut</option>
                <option value="PayPal">PayPal</option>
            `;
        } else {
            paymentSelect.innerHTML = `
                <option value="Visa">Visa</option>
                <option value="MasterCard">MasterCard</option>
                <option value="Revolut">Revolut</option>
                <option value="PayPal">PayPal</option>
            `;
        }

        updateCardField();
    };

    const updateCardField = () => {
        const selected = paymentSelect.value;
        cardInfo.style.display = selected === "Pay at counter" ? "none" : "block";
    };

    delivery.addEventListener('change', updatePaymentUI);
    paymentSelect.addEventListener('change', updateCardField);

    updatePaymentUI();
});
