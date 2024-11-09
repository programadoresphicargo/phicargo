// App.js
import React from 'react';
import { HashRouter as Router, Routes, Route, Navigate, Link } from 'react-router-dom';
import DetencionesTable from './llegadas_tarde/llegadas_tarde';
import AsignacionUnidades from './asignacion_unidades';

const App = () => {
    return (
        <Router>
            <Routes>
                <Route path="/detenciones" element={<DetencionesTable />} />
                <Route path="/asignacion" element={<AsignacionUnidades />} />
            </Routes>
        </Router>
    );
};

export default App;