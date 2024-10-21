import React, { useState, useEffect } from 'react';
import { Table, TableHeader, TableColumn, TableBody, TableRow, TableCell } from "@nextui-org/react";
import { Modal, ModalContent, ModalHeader, ModalBody, ModalFooter, Button, useDisclosure } from "@nextui-org/react";
import axios from 'axios';
import { Autocomplete, AutocompleteItem } from "@nextui-org/react";
import Box from '@mui/material/Box';
import Paper from '@mui/material/Paper';
import Grid from '@mui/material/Grid';
import { Card, CardHeader, CardBody, CardFooter, Divider, Link, Image } from "@nextui-org/react";
import { DatePicker } from "@nextui-org/react";
import { now, getLocalTimeZone } from "@internationalized/date";
import { Textarea } from "@nextui-org/input";
import { Select, SelectItem } from "@nextui-org/react";
import { Avatar } from "@nextui-org/react";
import { toast } from 'react-toastify';
import VehiculoForm from './vehiculoForm';
import { parseDate } from "@internationalized/date";
import { useDateFormatter } from "@react-aria/i18n";
import { parseZonedDateTime, parseAbsoluteToLocal } from "@internationalized/date";
import CustomDatePicker from './dateRange';

const AccesoForm = ({ id_acceso }) => {

    const [records, setRecords] = useState([]); // Estado para los registros de la tabla

    const areas = [
        'Edificio Administrativo',
        'Comedor',
        'Compras',
        'Nave Mantenimiento',
        'Servicontainer',
        'Scania',
        'Elektra',
        'Patio Maniobras',
        'Patio de Contenedores',
        'Diesel y Urea',
        'RFE (Comprobación y Revisión)',
        'Estacionamiento Externo',
        'Perímetro Interior',
        'Perímetro Exterior',
    ];

    const [selectedKey, setSelectedKey] = React.useState(1);

    const onSelectionChangeEmpresa = (id) => {
        fetchVisitantes();
        setSelectedKey(id);
    };

    const onSelectionChange = (item) => {
        setSelectedKey(item);
        console.log(item);
        if (!records.some((selected) => selected.value === item.value)) {
            setRecords([...records, item]);
        }
    };

    const deleteRecord = (recordToDelete) => {
        setRecords((prevRecords) => prevRecords.filter(record => record !== recordToDelete));
    };

    const saveChanges = () => {
        console.log('Guardando cambios:', records);
        alert('Cambios guardados correctamente.');
    };

    const [options2, setOptions] = useState([]);

    const getAcceso = async () => {
        try {
            const baseUrl = `/phicargo/accesos/accesos/getAcceso.php?id_acceso=${id_acceso}`;
            const response = await axios.get(baseUrl);
            const data = response.data[0];
            setFormData({
                id_maniobra: data.id_acceso || '',
                tipo_movimiento: data.tipo_movimiento || '',
                fecha_entrada: data.fecha_entrada || '',
            });

        } catch (error) {
            console.error("Error obteniendo los datos:", error);
        }
    };

    useEffect(() => {
        if (id_acceso) {
            getAcceso();
        }
    }, [id_acceso]);

    const fetchFlota = () => {
        const baseUrl = '/phicargo/accesos/empresas/getEmpresas.php';

        axios.get(baseUrl)
            .then(response => {
                const data = response.data.map(item => ({
                    value: Number(item.id_empresa),
                    label: item.nombre_empresa,
                }));
                setOptions(data);
            })
            .catch(err => {
                console.error('Error al obtener la flota:', err);
            });
    };

    const [visitantes, setVisitantes] = useState([]);

    const fetchVisitantes = () => {
        const baseUrl = '/phicargo/accesos/visitantes/getVisitantes.php?id_empresa=' + selectedKey;

        axios.get(baseUrl)
            .then(response => {
                const data = response.data.map(item => ({
                    value: Number(item.id_visitante),
                    label: item.nombre_visitante,
                }));
                setVisitantes(data);
            })
            .catch(err => {
                console.error('Error al obtener la flota:', err);
            });
    };

    useEffect(() => {
        fetchFlota();
    }, []);

    const { isOpen, onOpen, onClose } = useDisclosure();

    const handleOpen = () => {
        onOpen();
    }

    const [formData, setFormData] = useState({
        fecha_entrada: "2024-01-01 10:00:00", // Valor por defecto
        fecha_salida: "2024-01-02 15:00:00", // Otro valor por defecto
    });

    const handleDateChange = (key) => (newDate) => {
        setFormData((prevData) => ({
            ...prevData,
            [key]: newDate, // Actualiza la fecha correspondiente
        }));
    };

    return (
        <>
            <div style={{ padding: '20px' }}>
                <Button onClick={saveChanges} style={{ marginTop: '20px' }} color='primary'>Guardar Cambios</Button>
            </div>

            <Grid container spacing={2} style={{ padding: '20px' }}>
                <Grid item xs={12} sm={4} md={8}>

                    <Card className='mb-3'>
                        <CardHeader className="flex gap-3">
                            <div className="flex flex-col">
                                <p className="text-md">Datos del acceso</p>
                            </div>
                        </CardHeader>
                        <Divider />
                        <CardBody>

                            <Grid container spacing={2}>

                                <CustomDatePicker
                                    label="Fecha de entrada"
                                    value={formData.fecha_entrada}
                                    onChange={handleDateChange("fecha_entrada")}
                                />
                                <CustomDatePicker
                                    label="Fecha de salida"
                                    value={formData.fecha_entrada}
                                    onChange={handleDateChange("fecha_salida")}
                                />

                                <Grid item xs={12} sm={6} md={4}>
                                    <select
                                        id="tipo_mov"
                                        name="tipo_mov"
                                        label="Tipo de movimiento"
                                        className='form-control'
                                        value={formData.tipo_movimiento}
                                    >
                                        <option value="ingreso">Entrada a las instalaciones </option>
                                        <option value="salida">Salida de las intalaciones </option>
                                    </select>
                                </Grid>
                                <Grid item xs={12} sm={6} md={4}>
                                    <input
                                        label="Fecha de entrada"
                                        className='form-control'
                                        type='datetime-local'
                                        value={formData.fecha_entrada}
                                    />
                                </Grid>
                                <Grid item xs={12} sm={6} md={4}>
                                    <DatePicker
                                        label="Fecha de entrada"
                                        variant='faded'
                                        hideTimeZone
                                        showMonthAndYearPickers
                                        defaultValue={now(getLocalTimeZone())}
                                    />
                                </Grid>
                                <Grid item xs={12} sm={6} md={4}>
                                    <Autocomplete
                                        defaultItems={options2}
                                        label="Empresa"
                                        size='sm'
                                        variant='faded'
                                        onSelectionChange={onSelectionChangeEmpresa} // Función que gestiona la selección
                                    >
                                        {(item) => <AutocompleteItem key={item.value}>{item.label}</AutocompleteItem>}
                                    </Autocomplete>
                                </Grid>
                                <Grid item xs={12} sm={6} md={4}>
                                    <Autocomplete
                                        defaultItems={visitantes}
                                        variant="faded" // Asegúrate de que 'faded' sea un valor válido para 'variant'
                                        size="sm"
                                        label="Visitantes"
                                        placeholder="Selecciona los visitantes"
                                        onSelectionChange={onSelectionChange} // Función que gestiona la selección
                                    >
                                        {(user) => (
                                            <AutocompleteItem key={user.value} textValue={user.label}>
                                                <div className="flex gap-2 items-center">
                                                    <Avatar
                                                        alt={user.label}
                                                        className="flex-shrink-0"
                                                        size="sm"
                                                        src={"https://d2u8k2ocievbld.cloudfront.net/memojis/male/1.png"} // Verifica que los usuarios tengan una propiedad 'avatar'
                                                    />
                                                    <div className="flex flex-col">
                                                        <span className="text-small">{user.label}</span>
                                                        <span className="text-tiny text-default-400">{user.label}</span>
                                                    </div>
                                                </div>
                                            </AutocompleteItem>
                                        )}
                                    </Autocomplete>
                                </Grid>
                                <Grid item xs={12} sm={6} md={4}>
                                    <Button color="primary" size='lg'>
                                        Añadir visitante
                                    </Button>
                                </Grid>
                                <Grid item xs={12} sm={12} md={12}>
                                    <Table aria-label="Example static collection table" isStriped>
                                        <TableHeader>
                                            <TableColumn>Nombre del visitante</TableColumn>
                                            <TableColumn>Acciones</TableColumn>
                                        </TableHeader>
                                        <TableBody>
                                            {records.map((record, index) => (
                                                <TableRow key={index}>
                                                    <TableCell>{record}</TableCell>
                                                    <TableCell>
                                                        <Button color='primary' onClick={() => deleteRecord(record)}>Borrar</Button>
                                                    </TableCell>
                                                </TableRow>
                                            ))}
                                        </TableBody>
                                    </Table>
                                </Grid>

                                <Grid item xs={12} sm={6} md={6}>
                                    <Select
                                        label="Area a visitar"
                                        placeholder="Selecciona una opción"
                                        selectionMode="multiple"
                                        variant='faded'
                                    >
                                        {areas.map((option, index) => (
                                            <SelectItem key={index} value={option}>
                                                {option}
                                            </SelectItem>
                                        ))}
                                    </Select>
                                </Grid>
                                <Grid item xs={12} sm={6} md={6}>
                                    <Textarea
                                        label="Motivo de acceso o salida"
                                        placeholder="Ingresa una descripción"
                                        variant='faded'
                                    />
                                </Grid>
                            </Grid>
                        </CardBody>
                        <Divider />
                        <CardFooter>
                        </CardFooter>
                    </Card>

                    <Card>
                        <CardHeader className="flex gap-3">
                            <div className="flex flex-col">
                                <p className="text-md">Añadir vehiculo</p>
                            </div>
                        </CardHeader>
                        <Divider />
                        <CardBody>

                            <Grid container spacing={2}>
                                <Grid item xs={4}>
                                    <Button color="danger" size='lg' onClick={handleOpen}>
                                        Añadir vehiculo
                                    </Button>
                                </Grid>
                            </Grid>
                        </CardBody>
                        <Divider />
                        <CardFooter>
                        </CardFooter>
                    </Card>

                </Grid>

                <Grid item xs={4}>
                    <Card>
                        <CardHeader className="flex gap-3">
                            <div className="flex flex-col">
                                <p className="text-md">Historial de cambios</p>
                            </div>
                        </CardHeader>
                        <Divider />
                        <CardBody>
                            <Textarea
                                label="Notas para vigilancia"
                                placeholder="Ingresa tus notas"
                                className="max-w-xs"
                                variant='faded'
                            />
                        </CardBody>
                        <Divider />
                        <CardFooter>
                        </CardFooter>
                    </Card>
                </Grid>
            </Grid >

            <Modal isOpen={isOpen}
                onClose={onClose} >
                <ModalContent>
                    {(onClose) => (
                        <>
                            <ModalHeader className="flex flex-col gap-1">Nuevo vehiculo</ModalHeader>
                            <ModalBody>
                                <VehiculoForm></VehiculoForm>
                            </ModalBody>
                        </>
                    )}
                </ModalContent>
            </Modal>
        </>
    );
};

export default AccesoForm;
