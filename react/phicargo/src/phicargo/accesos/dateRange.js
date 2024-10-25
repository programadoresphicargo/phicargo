import { DatePicker } from "@nextui-org/react";
import dayjs from 'dayjs';

// Componente reutilizable para DatePicker
const CustomDatePicker = ({ label, value, onChange }) => {
    const handleDateChange = (newDate) => {
        if (newDate) {
            const formattedDate = dayjs(newDate).format("YYYY-MM-DD HH:mm:ss"); // Formato "YYYY-MM-DD HH:mm:ss"
            onChange(formattedDate); // Llama a la función de cambio con el nuevo valor
        }
    };

    return (
        <DatePicker
            label={label}
            variant="faded"
            hideTimeZone
            showMonthAndYearPickers
            value={dayjs(value)} // Convierte el valor a un objeto Day.js
            onChange={handleDateChange} // Controlar el cambio de fecha
        />
    );
};

export default CustomDatePicker;
