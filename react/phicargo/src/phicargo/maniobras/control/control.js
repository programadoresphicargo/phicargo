import React from "react";
import { Tabs, Tab, Card, CardBody } from "@nextui-org/react";
import Maniobras from "./tabla";
import ContainerOutsideExample from '../../../navbar';

export default function App() {
    return (
        <div>
            <ContainerOutsideExample />
            <div className="m-1">
                <Tabs aria-label="Options" color={'primary'} size="lg">
                    <Tab key="photos" title="Activas">
                        <Maniobras
                            estado_maniobra={'activa'} />
                    </Tab>
                    <Tab key="music" title="Programadas">
                        <Maniobras
                            estado_maniobra={'borrador'} />
                    </Tab>
                    <Tab key="videos" title="Finalizadas">
                        <Maniobras
                            estado_maniobra={'finalizada'} />
                    </Tab>
                </Tabs>
            </div>
        </div>
    );
}
