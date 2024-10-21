
import { Navbar, NavbarBrand, NavbarContent, NavbarItem, Button, DropdownItem, DropdownTrigger, Dropdown, DropdownMenu, NavbarMenuToggle, NavbarMenu, NavbarMenuItem } from "@nextui-org/react";
import React, { useState, useEffect } from 'react';
import { SearchIcon } from "./SearchIcon.jsx";
import { Link } from "react-router-dom";

function OffcanvasExample() {

    const [isMenuOpen, setIsMenuOpen] = React.useState(false);

    return (<>
        <Navbar onMenuOpenChange={setIsMenuOpen}>

            <NavbarContent>
                <NavbarMenuToggle
                    aria-label={isMenuOpen ? "Close menu" : "Open menu"}
                    className="sm:hidden"
                />
                <NavbarBrand>
                    <img src="https://phi-cargo.com/wp-content/uploads/2021/05/logo-phicargo-vertical.png" alt="Logo" width={150} />
                </NavbarBrand>
            </NavbarContent>

            <NavbarContent justify="start">
                <NavbarContent className="hidden sm:flex gap-3">
                    <Dropdown>
                        <NavbarItem>
                            <DropdownTrigger>
                                <Button
                                    disableRipple
                                    className="p-0 bg-transparent data-[hover=true]:bg-transparent"
                                    radius="sm"
                                    variant="light"
                                >
                                    Features
                                </Button>
                            </DropdownTrigger>
                        </NavbarItem>
                        <DropdownMenu
                            aria-label="ACME features"
                            className="w-[340px]"
                            itemClasses={{
                                base: "gap-4",
                            }}
                        >
                            <DropdownItem
                                key="autoscaling"
                            >
                                <Link to="/ViajesFinalizados">
                                    Viajes Finalizados
                                </Link>
                            </DropdownItem>
                        </DropdownMenu>
                    </Dropdown>
                    <NavbarItem>
                        <Link aria-current="page" color="secondary" to="/cartas porte">
                            Contenedores
                        </Link>
                    </NavbarItem>
                    <NavbarItem>
                        <Link to="/app" aria-current="page" color="secondary">
                            Control de maniobras
                        </Link>
                    </NavbarItem>
                    <NavbarItem>
                        <Link to="/nominas" aria-current="page" color="secondary">
                            Pagos
                        </Link>
                    </NavbarItem>
                    <NavbarItem>
                        <Link to="/precios" aria-current="page" color="secondary">
                            Precios maniobras
                        </Link>
                    </NavbarItem>
                    <NavbarItem>
                        <Link to="/disponibilidad" aria-current="page" color="secondary">
                            Disponibilidad
                        </Link>
                    </NavbarItem>
                    <NavbarItem>
                        <Link to="/terminales" aria-current="page" color="secondary">
                            Terminales
                        </Link>
                    </NavbarItem>
                </NavbarContent>
                <NavbarMenu>
                    <NavbarMenuItem>
                        <Link aria-current="page" color="secondary" to="/cartas porte">
                            Contenedores
                        </Link>
                    </NavbarMenuItem>
                    <NavbarMenuItem>
                        <Link aria-current="page" color="secondary" to="/app">
                            Control de maniobras
                        </Link>
                    </NavbarMenuItem>
                    <NavbarMenuItem>
                        <Link to="/nominas" aria-current="page" color="secondary">
                            Pagos
                        </Link>
                    </NavbarMenuItem>
                    <NavbarMenuItem>
                        <Link to="/precios" aria-current="page" color="secondary">
                            Precios maniobras
                        </Link>
                    </NavbarMenuItem>
                    <NavbarMenuItem>
                        <Link to="/disponibilidad" aria-current="page" color="secondary">
                            Disponibilidad
                        </Link>
                    </NavbarMenuItem>
                    <NavbarMenuItem>
                        <Link to="/terminales" aria-current="page" color="secondary">
                            Terminales
                        </Link>
                    </NavbarMenuItem>
                </NavbarMenu>
            </NavbarContent>
        </Navbar>
    </>
    );
}

export default OffcanvasExample;