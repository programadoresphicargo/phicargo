import React, { useState, useEffect, useMemo } from 'react';
import {
    Dialog,
    DialogTitle,
    DialogContent,
    DialogActions,
    Button,
    MenuItem,
    Select,
    CircularProgress,
} from '@mui/material';
import ContainerOutsideExample from '../../../navbar';
import MonthSelector from '../../../mes';
import { ThemeProvider } from '@mui/material/styles';
import customFontTheme from '../../../theme';
import {
    MaterialReactTable,
    useMaterialReactTable,
} from 'material-react-table';
import { toast } from 'react-toastify';

const Disponibilidad_unidades = () => {
    const [isLoading2, setLoading] = useState();
    const [data, setData] = useState([]);
    const [openDialog, setOpenDialog] = useState(false);
    const [selectedRow, setSelectedRow] = useState(null);
    const [estado, setStatus] = useState('');
    const [isUpdating, setIsUpdating] = useState(false);

    const fetchData = async () => {
        setLoading(true);
        try {
            const response = await fetch('/phicargo/disponibilidad/equipos/getEquipos.php');
            const jsonData = await response.json();
            setData(jsonData);
            setLoading(false);
        } catch (error) {
            console.error('Error al obtener los datos:', error);
        }
    };

    useEffect(() => {
        fetchData();
    }, []);

    const columns = useMemo(
        () => [
            {
                accessorKey: 'name2',
                header: 'Vehículo',
            },
            {
                accessorKey: 'serial_number',
                header: 'Número de serie',
            },
            {
                accessorKey: 'license_plate',
                header: 'Placas',
            },
            {
                accessorKey: 'fleet_type',
                header: 'Tipo de vehiculo',
            },
            {
                accessorKey: 'x_status',
                header: 'Estado',
            },
        ],
        [],
    );

    const handleRowClick = (row) => {
        setSelectedRow(row.original);
        setStatus(row.original.x_status);
        setOpenDialog(true);
    };

    const handleUpdateStatus = async () => {
        setIsUpdating(true);
        try {
            const response = await fetch('/phicargo/disponibilidad/equipos/guardar_cambios.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    id: selectedRow.id,
                    estado: estado,
                }),
            });

            const result = await response.json();
            if (result.success) {
                toast.success('Estado actualizado con éxito');
                setOpenDialog(false);
                fetchData();
            } else {
                toast.error('Error al actualizar el estado');
            }
        } catch (error) {
            console.error('Error en la actualización:', error);
            toast.error('Error en la actualización');
        } finally {
            setIsUpdating(false);
        }
    };

    const table = useMaterialReactTable({
        columns,
        data,
        enableGrouping: true,
        enableGlobalFilter: true,
        enableFilters: true,
        initialState: {
            density: 'compact',
            pagination: { pageSize: 80 },
        },
        state: { isLoading: isLoading2 },
        muiTableBodyRowProps: ({ row }) => ({
            onClick: () => handleRowClick(row), // Abre el diálogo al hacer clic en la fila
            style: {
                cursor: 'pointer',
            },
        }),
        muiTableHeadCellProps: {
            sx: {
                fontFamily: 'Inter',
                fontWeight: 'Bold',
                fontSize: '14px',
            },
        },
        muiTableBodyCellProps: {
            sx: {
                fontFamily: 'Inter',
                fontWeight: 'normal',
                fontSize: '14px',
            },
        },
    });

    return (
        <div>
            <ContainerOutsideExample />
            <ThemeProvider theme={customFontTheme}>
                <MaterialReactTable table={table} />
            </ThemeProvider>

            <Dialog open={openDialog} onClose={() => setOpenDialog(false)}>
                <DialogTitle>Actualizar Estado del Vehículo</DialogTitle>
                <DialogContent>
                    <Select
                        fullWidth
                        value={estado}
                        onChange={(e) => setStatus(e.target.value)}
                    >
                        <MenuItem value="disponible">Disponible</MenuItem>
                        <MenuItem value="viaje">Viaje</MenuItem>
                        <MenuItem value="mantenimiento">Mantenimiento</MenuItem>
                        <MenuItem value="maniobra">Maniobra</MenuItem>
                    </Select>
                </DialogContent>
                <DialogActions>
                    <Button onClick={() => setOpenDialog(false)}>Cancelar</Button>
                    <Button onClick={handleUpdateStatus} disabled={isUpdating}>
                        {isUpdating ? <CircularProgress size={24} /> : 'Actualizar'}
                    </Button>
                </DialogActions>
            </Dialog>
        </div>
    );
};

export default Disponibilidad_unidades;