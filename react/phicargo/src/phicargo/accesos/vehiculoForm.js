import { useState } from "react";
import { Input } from "@nextui-org/react";
import { Button } from "@nextui-org/button";
import { Select, SelectItem } from "@nextui-org/react";
import axios from "axios";

const VehiculoForm = () => {
    const [marca, setMarca] = useState("");
    const [modelo, setModelo] = useState("");
    const [placas, setPlacas] = useState("");
    const [tipoVehiculo, setTipoVehiculo] = useState("");
    const [color, setColor] = useState("");
    const [referencia1, setReferencia1] = useState("");
    const [referencia2, setReferencia2] = useState("");

    const handleSubmit = async () => {

        const vehiculoData = {
            marca,
            modelo,
            placas,
            tipoVehiculo,
            color,
            referencia1,
            referencia2,
        };

        try {
            const response = await axios.post("/phicargo/accesos/vehiculos/registrar_vehiculo.php", vehiculoData);
            console.log("Datos enviados exitosamente:", response.data);
        } catch (error) {
            console.error("Error enviando los datos:", error);
        }
    };

    return (
        <div className="flex w-full flex-wrap md:flex-nowrap gap-4 mb-5">
            <Input
                type="text"
                variant="faded"
                label="Marca"
                value={marca}
                onChange={(e) => setMarca(e.target.value)}
            />
            <Input
                type="text"
                variant="faded"
                label="Modelo"
                value={modelo}
                onChange={(e) => setModelo(e.target.value)}
            />
            <Input
                type="text"
                variant="faded"
                label="Placas"
                value={ placas}
                onChange={(e) => setPlacas(e.target.value)}
            />

            <Select
                label="Tipo de vehiculo"
                variant="faded"
                value={tipoVehiculo}  // Debes asegurar que esto sea un valor primitivo (string, number)
                onChange={setTipoVehiculo}  // Aquí actualizas solo el valor
            >
                <SelectItem key={'tractocamion'} value="tractocamion">Tractocamión</SelectItem>
                <SelectItem key={'pipa'} value="pipa">Pipa</SelectItem>
                <SelectItem key={'automovil'} value="automovil">Automovil</SelectItem>
                <SelectItem key={'motocicleta'} value="motocicleta">Motocicleta</SelectItem>
                <SelectItem key={'camion'} value="camion">Camión</SelectItem>
                <SelectItem key={'grua'} value="grua">Grua</SelectItem>
            </Select>

            <Input
                type="text"
                variant="faded"
                label="Color"
                value={color}
                onChange={(e) => setColor(e.target.value)}
            />
            <Input
                type="text"
                variant="faded"
                label="Referencia contenedor 1"
                value={referencia1}
                onChange={(e) => setReferencia1(e.target.value)}
            />
            <Input
                type="text"
                variant="faded"
                label="Referencia contenedor 2"
                value={referencia2}
                onChange={(e) => setReferencia2(e.target.value)}
            />

            <Button onPress={handleSubmit}>Registrar vehiculo</Button>
        </div>
    );
}

export default VehiculoForm;
