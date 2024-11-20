function addSchedule() {
    const container = document.getElementById("schedules-container");
    const scheduleDiv = document.createElement("div");

    scheduleDiv.innerHTML = `
        <label>Día de la Semana:</label>
        <select name="day_of_week[]" required>
            <option value="lunes">Lunes</option>
            <option value="martes">Martes</option>
            <option value="miercoles">Miércoles</option>
            <option value="jueves">Jueves</option>
             <option value="viernes">Viernes</option>
            <option value="sabado">Sábado</option>
            <option value="domingo">Domingo</option>
        </select>
        <label>Hora:</label>
        <input type="time" name="time[]" required>
        <button type="button" onclick="this.parentNode.remove()">Eliminar horario</button>
    `;
    container.appendChild(scheduleDiv);
}