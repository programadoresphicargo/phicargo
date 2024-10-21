import React, { useState, useEffect, useMemo } from 'react';

import {
  MaterialReactTable,
  useMaterialReactTable,
} from 'material-react-table';

const Viaje = ({ id_viaje }) => {

  const [data, setData] = useState(null);
  const [isLoading2, setLoading] = useState();

  useEffect(() => {
    const fetchData = async () => {

      try {
        setLoading(true);
        const response = await fetch('/phicargo/gestion_viajes/viaje/getViaje.php?id_viaje=' + id_viaje);
        const jsonData = await response.json();
        setData(jsonData);
        setLoading(false);
      } catch (error) {
        console.error('Error al obtener los datos:', error);
      }
    };

    fetchData();
  }, []);

  return (
    <div>
      <div className="content bg-white" style={{ boxShadow: "0 4px 6px rgba(0, 0, 0, 0.03)" }}>
        <div className="row" style={{ marginLeft: "15px", marginRight: "15px" }}>
          <div className="col-lg-12">
            <h1 className="page-header-title">{data.name}</h1>
            <ul className="list-inline list-px-2">
              <li className="list-inline-item">
                <span className="badge bg-success rounded-pill ms-1">
                  <i className="bi bi-bookmark"></i>
                </span>
                <span className="badge bg-danger rounded-pill ms-1">
                  <i className="bi bi-bookmark"></i>
                </span>
              </li>
              <li className="list-inline-item">
                <i className="bi bi-person"></i>
                <span></span>
              </li>
              <li className="list-inline-item">
                <i className="bi bi-truck"></i>
                <span></span>
              </li>
              <li className="list-inline-item">
                <span className="badge bg-danger rounded-pill ms-1">Lleva custodia</span>
              </li>
            </ul>
          </div>
          <div className="col-lg-6 col-sm-7 col-md-7">
            <button
              className="btn btn-success btn-xs"
              type="button"
              id="Iniciar_modal"
              style={{ display: "none", width: "150px" }}
            >
              <i className="bi bi-play-fill"></i> Iniciar
            </button>
            <button className="btn btn-danger btn-xs" type="button" id="Finalizar_modal" style={{ display: "none" }}>
              <i className="bi bi-pause"></i> Finalizar
            </button>
            <button className="btn btn-primary btn-xs" type="button" id="offpods">
              <i className="bi bi-file-earmark-text-fill"></i> Documentos
            </button>
            <button className="btn btn-warning btn-xs text-white" type="button" id="checklist">
              <i className="bi bi-file-earmark-text-fill"></i> Checklist
            </button>
            <button className="btn btn-danger btn-xs" id="abrir_alertas_detalle" type="button">
              <i className="bi bi-sign-stop"></i> Alertas y Detenciones
            </button>
            <button
              className="btn btn-primary btn-xs"
              type="button"
              id="Finalizado"
              disabled
              style={{ display: "none" }}
            >
              <span data-feather="check" className="feather-sm me-1"></span> Finalizado
            </button>
            <button
              className="btn btn-morado btn-xs"
              type="button"
              id="modal_resguardo"
              style={{ display: "none" }}
            >
              <span data-feather="check" className="feather-sm me-1"></span>
              <i className="bi bi-truck"></i> Liberar resguardo
            </button>
            <button
              id="btn_enviar_status"
              type="button"
              className="btn btn-success btn-xs"
              style={{ display: "none" }}
            >
              <i className="bi bi-send-plus"></i> Enviar nuevo estatus
            </button>
            <button
              type="button"
              className="btn btn-primary btn-xs"
              id="modal_ligar_abrir"
              style={{ display: "none" }}
            >
              <i className="bi bi-envelope-plus"></i> Correos ligados
            </button>
            <button id="cancelar_viaje_modal" type="button" className="btn btn-danger btn-xs" style={{ display: "none" }}>
              <i className="bi bi-x-circle"></i> Cancelar
            </button>
            <button id="reactivar_viaje" type="button" className="btn btn-success btn-xs" style={{ display: "none" }}>
              <i className="bi bi-check-circle"></i> Reactivar
            </button>
            <button id="abrir_incidencias_canvas" type="button" className="btn btn-danger btn-xs">
              <i className="bi bi-exclamation-triangle-fill"></i> Registrar para entrega
            </button>
            <button id="abrir_custodia_canvas" type="button" className="btn btn-primary btn-xs">
              <i className="bi bi-exclamation-triangle-fill"></i> Custodia
            </button>
          </div>
        </div>
      </div>
    </div>
  );
};

export default Viaje;
