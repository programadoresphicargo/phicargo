import React, { useState, useEffect } from 'react';
import { MaterialReactTable } from 'material-react-table';
import axios from 'axios';
import Badge from 'react-bootstrap/Badge';
import { Box, Button } from '@mui/material';
import FileDownloadIcon from '@mui/icons-material/FileDownload';
import PaginaConDialog from './informacion';
import * as XLSX from 'xlsx';
import { saveAs } from 'file-saver';

const AsignacionUnidades = () => {

    const [open, setOpen] = useState(false);
    const [id_vehicle, setIDVehicle] = useState('');
    const [vehicle_name, setNameVehicle] = useState('');
    const [loading, setLoading] = useState(true);
    const [data, setData] = useState([]);

    const handleClickOpen = () => {
        setOpen(true);
    };

    const handleClose = () => {
        setOpen(false);
        fetchData();
    };

    useEffect(() => {
        fetchData();
    }, []);

    const fetchData = async () => {
        try {
            setLoading(true);
            const response = await axios.get('/phicargo/reportes/unidades/getData.php');
            setData(response.data || []);
            setLoading(false);
        } catch (error) {
            console.error('Error al enviar los datos:', error);
        }
    };

    const columns = [
        { accessorKey: 'empresa', header: 'Empresa' },
        { accessorKey: 'sucursal', header: 'Sucursal' },
        { accessorKey: 'name2', header: 'Unidad' },
        {
            accessorKey: 'operador_asignado',
            header: 'Operador asignado',
            Cell: ({ cell }) => cell.getValue() ? cell.getValue() : 'SIN OPERADOR ASIGNADO',
        },
        { accessorKey: 'x_tipo_vehiculo', header: 'Tipo de vehículo' },
        { accessorKey: 'x_tipo_carga', header: 'Tipo de carga' },
        { accessorKey: 'x_modalidad', header: 'Modalidad' },
        { accessorKey: 'estado_unidad', header: 'Estado' },
    ];

    const exportToExcel = () => {
        const formattedData = data.map(row => ({
            Sucursal: row.sucursal,
            Unidad: row.name2,
            'Operador asignado': row.operador_asignado ? row.operador_asignado : 'SIN OPERADOR ASIGNADO',
            'Tipo de vehículo': row.x_tipo_vehiculo,
            'Tipo de carga': row.x_tipo_carga,
            Modalidad: row.x_modalidad,
            Estado: row.estado_unidad,
        }));

        const worksheet = XLSX.utils.json_to_sheet(formattedData);
        const workbook = XLSX.utils.book_new();
        XLSX.utils.book_append_sheet(workbook, worksheet, 'DatosTabla');
        const excelBuffer = XLSX.write(workbook, { bookType: 'xlsx', type: 'array' });
        const data = new Blob([excelBuffer], { type: 'application/octet-stream' });
        saveAs(data, 'tabla.xlsx');
    };

    return (
        <div>
            <PaginaConDialog open={open} onClose={handleClose} id={id_vehicle} name={vehicle_name} />
            <MaterialReactTable
                columns={columns}
                data={data}
                state={{ isLoading: loading }}
                enableGrouping
                enableRowSelection
                columnFilterDisplayMode='popover'
                paginationDisplayMode='pages'
                positionToolbarAlertBanner='bottom'
                muiTableBodyRowProps={({ row }) => ({
                    onClick: () => {
                        handleClickOpen();
                        setIDVehicle(row.original.id_vehicle);
                        setNameVehicle(row.original.name2);
                    },
                    sx: {
                        cursor: 'pointer',
                    },
                })}
                initialState={{
                    density: 'compact',
                    pagination: { pageSize: 80 },
                }}
                renderTopToolbarCustomActions={() => (
                    <Box
                        sx={{
                            display: 'flex',
                            gap: '16px',
                            padding: '8px',
                            flexWrap: 'wrap',
                        }}
                    >
                        <Button variant="contained" startIcon={<FileDownloadIcon />} onClick={exportToExcel}>
                            Exportar a Excel
                        </Button>
                    </Box>
                )}
            />
        </div>
    );
};

export default AsignacionUnidades;
