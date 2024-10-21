import React, { useState, useEffect, useMemo } from 'react';
import { TextField } from '@mui/material';
import dayjs from 'dayjs';
import Button from '@mui/material/Button';
import Dialog from '@mui/material/Dialog';
import ListItemText from '@mui/material/ListItemText';
import ListItemButton from '@mui/material/ListItemButton';
import List from '@mui/material/List';
import Divider from '@mui/material/Divider';
import AppBar from '@mui/material/AppBar';
import Toolbar from '@mui/material/Toolbar';
import IconButton from '@mui/material/IconButton';
import Typography from '@mui/material/Typography';
import CloseIcon from '@mui/icons-material/Close';
import Slide from '@mui/material/Slide';
import { TransitionProps } from '@mui/material/transitions';
import AccesoForm from './formulario';

import {
  MaterialReactTable,
  useMaterialReactTable,
} from 'material-react-table';

const Transition = React.forwardRef(function Transition(props, ref) {
  return <Slide direction="up" ref={ref} {...props} />;
});

const Maniobras = ({ estado_maniobra }) => {

  const [open, setOpen] = React.useState(false);
  const [id_acceso, setIDAcceso] = useState(0);
  const handleClickOpen = () => {
    setOpen(true);
  };

  const handleClose = () => {
    setOpen(false);
  };

  const [data, setData] = useState([]);
  const [isLoading2, setLoading] = useState();

  useEffect(() => {
    const fetchData = async () => {

      try {
        setLoading(true);
        const response = await fetch('/phicargo/accesos/accesos/getAccesos.php?estado_maniobra=' + estado_maniobra);
        const jsonData = await response.json();
        setData(jsonData);
        setLoading(false);
      } catch (error) {
        console.error('Error al obtener los datos:', error);
      }
    };

    fetchData();
  }, []);

  const columns = useMemo(
    () => [
      {
        accessorKey: 'id_acceso',
        header: 'ID Acceso',
      },
      {
        accessorKey: 'nombre_empresa',
        header: 'Empresa visitante',
      },
      {
        accessorKey: 'tipo_movimiento',
        header: 'Tipo de movimiento',
      },
      {
        accessorKey: 'fecha_entrada',
        header: 'Fecha de entrada',
      },
      {
        accessorKey: 'nombre',
        header: 'Solicitado por',
      },
    ],
    [],
  );

  const manualGrouping = ['nombre_operador'];

  const table = useMaterialReactTable({
    columns,
    data,
    enableGrouping: true,
    enableGlobalFilter: true,
    enableFilters: true,
    state: { isLoading: isLoading2 },
    enableColumnPinning: true,
    enableStickyHeader: true,
    columnResizeMode: "onEnd",
    grouping: manualGrouping,
    initialState: {
      density: 'compact',
      pagination: { pageSize: 80 },
    },
    muiTablePaperProps: {
      elevation: 0,
      sx: {
        borderRadius: '0',
      },
    },
    muiTableBodyRowProps: ({ row }) => ({
      onClick: ({ event }) => {

        if (row.subRows?.length) {
        } else {
          handleClickOpen();
          setIDAcceso(row.original.id_acceso);
        }
      },
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

  return (<>

    <Dialog
      fullScreen
      open={open}
      onClose={handleClose}
      TransitionComponent={Transition}
    >
      <AppBar sx={{ position: 'relative' }} elevation={0}>
        <Toolbar>
          <IconButton
            edge="start"
            color="inherit"
            onClick={handleClose}
            aria-label="close"
          >
            <CloseIcon />
          </IconButton>
          <Typography sx={{ ml: 2, flex: 1 }} variant="h6" component="div">
            Acceso
          </Typography>
          <Button autoFocus color="inherit" onClick={handleClose}>
            Cerrar
          </Button>
        </Toolbar>
      </AppBar>
      <AccesoForm id_acceso={id_acceso}></AccesoForm>
    </Dialog>

    <div>
      <div className="table-striped">
        <MaterialReactTable table={table} />
      </div>
    </div >
  </>
  );

};

export default Maniobras;
