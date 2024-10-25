import React, { useEffect } from 'react';
import ReactDOM from 'react-dom';
import { HashRouter as Router, Routes, Route, Navigate } from 'react-router-dom';
import axios from 'axios';
import CartasPorte from './phicargo/maniobras/tms_waybill/cartas_porte';
import App from './phicargo/maniobras/control/control';
import Nominas from './phicargo/maniobras/pagos/pagos';
import Precios_maniobras from './phicargo/maniobras/precios/precios';
import Disponibilidad_unidades from './phicargo/disponiblidad/equipos/equipos';
import { ToastContainer } from 'react-toastify';
import Terminales from './phicargo/maniobras/maniobras/terminales/registros';
import 'react-toastify/dist/ReactToastify.css';
import ViajesFinalizados from './phicargo/gestion_viajes/finalizados/viajes';
import AccesoForm from './phicargo/accesos/formulario';
import Accesos from './phicargo/accesos/Accesos';
import './theme.min.css'

function Example() {

  useEffect(() => {
    const checkSession = async () => {
      const response = await fetch('/phicargo/login/inicio/check_session.php');
      const data = await response.json();

      if (data.status === 'success') {
      } else {
        window.location.href = 'https://www.phicargo-sistemas.online/phicargo/login/inicio/index.php';
      }
    };

    checkSession();
    const intervalId = setInterval(checkSession, 60000);
    return () => clearInterval(intervalId);
  }, []);

  return (
    <div>
      <ToastContainer />
      <Router>
        <Routes>
          {/* Ruta predeterminada */}
          <Route path="/" element={<Navigate to="/cartas-porte" />} />
          <Route path='/cartas-porte' element={<CartasPorte />} />
          <Route path='/app' element={<App />} />
          <Route path='/nominas' element={<Nominas />} />
          <Route path='/precios' element={<Precios_maniobras />} />
          <Route path='/disponibilidad' element={<Disponibilidad_unidades />} />
          <Route path='/terminales' element={<Terminales />} />
          <Route path='/ViajesFinalizados' element={<ViajesFinalizados />} />
          
          <Route path='/Accesos' element={<Accesos />} />
          <Route path='/AccesoForm' element={<AccesoForm />} />

          {/* Ruta para manejar rutas no válidas */}
          <Route path="*" element={<Navigate to="/" />} />
        </Routes>
      </Router>
    </div>
  );
};

export default Example;
