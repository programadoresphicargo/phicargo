import React, { useEffect } from 'react';
import { HashRouter as Router, Routes, Route, Navigate } from 'react-router-dom';
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
import EntregaMonitoreo from './phicargo/monitoreo/monitoreo';
import PersistentDrawer from './phicargo/monitoreo/Eventos';
import DetencionesTable from './phicargo/reportes/llegadas_tarde/llegadas_tarde';
import AsignacionUnidades from './phicargo/reportes/asignacion_unidades';
import './theme.min.css'
import CartasPorte from './phicargo/maniobras/tms_waybill/cartas_porte';
import ControlViajes from './phicargo/gestion_viajes/viaje/viaje';
import ControlUsuarios from './phicargo/usuarios/ControlUsuarios';
import Menu from './phicargo/menu/menu';

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

          <Route path="/menu" element={<Menu />} />

          <Route path="/" element={<Navigate to="/cartas-porte" />} />
          <Route path='/cartas-porte' element={<CartasPorte />} />
          <Route path='/control_maniobras' element={<App />} />
          <Route path='/nominas' element={<Nominas />} />
          <Route path='/precios' element={<Precios_maniobras />} />
          <Route path='/disponibilidad' element={<Disponibilidad_unidades />} />
          <Route path='/terminales' element={<Terminales />} />

          <Route path='/ControlViajes' element={<ControlViajes />} />
          <Route path='/ViajesFinalizados' element={<ViajesFinalizados />} />

          <Route path='/Accesos' element={<Accesos />} />
          <Route path='/AccesoForm' element={<AccesoForm />} />
          <Route path='/Monitoreo' element={<EntregaMonitoreo />} />
          <Route path='/Monitorista' element={<PersistentDrawer />} />

          <Route path="/detenciones" element={<DetencionesTable />} />
          <Route path="/asignacion" element={<AsignacionUnidades />} />

          <Route path="/usuarios" element={<ControlUsuarios />} />

          {/* Ruta para manejar rutas no válidas */}
          <Route path="*" element={<Navigate to="/" />} />
        </Routes>
      </Router>
    </div>
  );
};

export default Example;
