function addSubscription() {
    const container = document.getElementById("subscriptions-container");
    const subscriptionDiv = document.createElement("div");

    subscriptionDiv.innerHTML = `
        <label>Frecuencia:</label>
        <select name="frequency[]" required>
            <option value="una">Una vez</option>
            <option value="dos">Dos veces</option>
            <option value="tres">Tres veces</option>
            <option value="ilimitado">Ilimitado</option>
        </select>
        <label>Precio:</label>
        <input type="number" name="subscription_price[]" required>
        <button type="button" onclick="this.parentNode.remove()">Eliminar abono</button>
    `;
    container.appendChild(subscriptionDiv);
};