import React, { useState, useEffect, useMemo } from 'react';
import {
    MaterialReactTable,
    useMaterialReactTable,
} from 'material-react-table';

const ReporteCumplimiento = () => {

    const [data, setData] = useState([]);

    useEffect(() => {
        const fetchData = async () => {

            try {
                const response = await fetch('/phicargo/reportes/porcentajes_status/get_registros.php');
                const jsonData = await response.json();
                setData(jsonData);
            } catch (error) {
                console.error('Error al obtener los datos:', error);
            }
        };

        fetchData();
    }, []);

    const columns = useMemo(
        () => [
            {
                accessorKey: 'referencia',
                header: 'Sucursal',
            },
            {
                accessorKey: 'name',
                header: 'Operador',
                size: 150,
            },
            {
                accessorKey: 'fecha_inicio',
                header: 'Fecha inicio',
                size: 150,
            },
            {
                accessorKey: 'estatus_enviados',
                header: 'Estatus enviados',
                size: 150,
            },
            {
                accessorKey: 'porcentaje_estatus',
                header: 'Porcentaje de cumplimiento',
                size: 150,
            },
            {
                accessorKey: 'estatus_encontrados',
                header: 'Estatus_enviados',
                size: 100,
            },
        ],
        [],
    );

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
        muiTableBodyRowProps: ({ row }) => ({
            onClick: ({ event }) => {
            },
            style: {
                cursor: 'pointer',
            },
        }),
    });

    return (
        <div>
            <MaterialReactTable table={table} />
        </div >
    );

};

export default ReporteCumplimiento;
