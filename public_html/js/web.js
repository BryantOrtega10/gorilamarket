const API_KEY_GEO_MAP = 'AIzaSyDsTUUgsrFvaF-ukEho0BOXIaaRT7Wo6Cw';

const bindEvent = (eventNames, selector, handler) => {
    eventNames.split(' ').forEach((eventName) => {
        document.addEventListener(eventName, function (event) {
            if (event.target.matches(selector + ', ' + selector + ' *')) {
                handler.apply(event.target.closest(selector), arguments)
            }
        }, false)
    })
}


const abrirCarrito = (url) => {
    fetch(url)
        .then((response) => response.text())
        .then((text) => {

            const contenedorCarro = document.querySelector(".contenedor-ajax-carrito");
            contenedorCarro.innerHTML = text;
            setTimeout(() => {
                document.querySelector(".carrito").classList.add('mostrar');
            }, 50);
            document.querySelector("body").classList.add('overflow-hidden');
        })
        .catch((error) => console.error("Error:", error));
}


const itemsCarrito = document.querySelectorAll(".agregar-carrito");
itemsCarrito.forEach(item => {
    item.addEventListener("click", (e) => {
        e.preventDefault();
        let elemento = e.target;
        if (elemento.classList.contains('fa-solid')) {
            elemento = elemento.parentNode;
        }
        if (elemento.classList.contains('icono-carrito')) {
            elemento = elemento.parentNode;
        }

        const url = elemento.dataset.url;
        fetch(url)
            .then((res) => res.json())
            .catch((error) => console.error("Error:", error))
            .then((response) => {
                if (elemento.classList.contains('reload')) {
                    window.location.reload();
                }


                if (response.carrito.cuentaProductos > 0) {
                    document.querySelector(".cantidad-productos").classList.remove("d-none");
                    document.querySelector(".cantidad-productos").innerHTML = response.carrito.cuentaProductos;
                }
                const btnCarrito = document.querySelector(".btn-carrito");
                abrirCarrito(btnCarrito.href);
            });
    });
});

bindEvent("click",".btn-carrito", (e) => {
    e.preventDefault();
    const btnCarrito = document.querySelector(".btn-carrito");
    abrirCarrito(btnCarrito.href);
})

bindEvent("click", ".quitar-producto", (e) => {
    e.preventDefault();
    const url = e.target.dataset.url;
    fetch(url)
        .then((res) => res.json())
        .catch((error) => console.error("Error:", error))
        .then((response) => {
            const carrito = response.carrito;
            const idproducto = response.idproducto;
            if (carrito.cuentaProductos == 0) {
                document.querySelector(".cantidad-productos").classList.add("d-none");
                document.querySelector(".cantidad-productos").innerHTML = 0;
            }
            document.querySelector(".cantidad-productos").innerHTML = response.carrito.cuentaProductos;

            if (typeof carrito.productos[idproducto] === 'undefined') {
                document.querySelector(`.producto[data-id='${idproducto}']`).remove();
            }
            else {
                document.querySelector(`.cant-productos-carrito[data-id='${idproducto}']`).innerHTML = carrito.productos[idproducto];
                document.querySelector(`.precio1[data-id='${idproducto}']`).innerHTML = response.precio1;
                document.querySelector(`.precio2[data-id='${idproducto}']`).innerHTML = response.precio2;

            }
            document.querySelector(`.subtotal`).innerHTML = response.subtotal_txt;
            const total_el = document.querySelector(`.total`);
            if (typeof total_el !== 'undefined' && total_el !== null) {
                document.querySelector(`.total`).innerHTML = response.total;
            }
            const descuento_el = document.querySelector(`.descuento`);
            if (typeof descuento_el !== 'undefined' && descuento_el !== null) {
                descuento_el.innerHTML = response.descuento;
            }
            const costoDomicilio_el = document.querySelector(`.costoDomicilio`);
            if (typeof costoDomicilio_el !== 'undefined' && costoDomicilio_el !== null) {
                costoDomicilio_el.innerHTML = response.costoDomicilio;
            }
        });
});

bindEvent("click", ".menos-unidades", (e) => {
    e.preventDefault();
    let elemento = e.target;
    if (elemento.classList.contains('fa-solid')) {
        elemento = elemento.parentNode;
    }

    const url = elemento.href;
    fetch(url)
        .then((res) => res.json())
        .catch((error) => console.error("Error:", error))
        .then((response) => {
            const carrito = response.carrito;
            const idproducto = response.idproducto;
            if (carrito.cuentaProductos == 0) {
                document.querySelector(".cantidad-productos").classList.add("d-none");
                document.querySelector(".cantidad-productos").innerHTML = 0;
            }
            document.querySelector(".cantidad-productos").innerHTML = response.carrito.cuentaProductos;

            if (typeof carrito.productos[idproducto] === 'undefined') {
                document.querySelector(`.producto[data-id='${idproducto}']`).remove();
            }
            else {
                document.querySelector(`.cant-productos-carrito[data-id='${idproducto}']`).innerHTML = carrito.productos[idproducto];
                document.querySelector(`.precio1[data-id='${idproducto}']`).innerHTML = response.precio1;
                document.querySelector(`.precio2[data-id='${idproducto}']`).innerHTML = response.precio2;

            }
            document.querySelector(`.subtotal`).innerHTML = response.subtotal_txt;
            const total_el = document.querySelector(`.total`);
            if (typeof total_el !== 'undefined' && total_el !== null) {
                document.querySelector(`.total`).innerHTML = response.total;
            }
            const descuento_el = document.querySelector(`.descuento`);
            if (typeof descuento_el !== 'undefined' && descuento_el !== null) {
                descuento_el.innerHTML = response.descuento;
            }
            const costoDomicilio_el = document.querySelector(`.costoDomicilio`);
            if (typeof costoDomicilio_el !== 'undefined' && costoDomicilio_el !== null) {
                costoDomicilio_el.innerHTML = response.costoDomicilio;
            }
        });
});
bindEvent("click", ".mas-unidades", (e) => {
    e.preventDefault();
    let elemento = e.target;
    if (elemento.classList.contains('fa-solid')) {
        elemento = elemento.parentNode;
    }

    const url = elemento.href;
    fetch(url)
        .then((res) => res.json())
        .catch((error) => console.error("Error:", error))
        .then((response) => {
            const carrito = response.carrito;
            const idproducto = response.idproducto;
            document.querySelector(".cantidad-productos").innerHTML = response.carrito.cuentaProductos;
            document.querySelector(`.cant-productos-carrito[data-id='${idproducto}']`).innerHTML = carrito.productos[idproducto];
            document.querySelector(`.precio1[data-id='${idproducto}']`).innerHTML = response.precio1;
            document.querySelector(`.precio2[data-id='${idproducto}']`).innerHTML = response.precio2;
            document.querySelector(`.subtotal`).innerHTML = response.subtotal_txt;
            const total_el = document.querySelector(`.total`);
            if (typeof total_el !== 'undefined' && total_el !== null) {
                document.querySelector(`.total`).innerHTML = response.total;
            }
            const descuento_el = document.querySelector(`.descuento`);
            if (typeof descuento_el !== 'undefined' && descuento_el !== null) {
                descuento_el.innerHTML = response.descuento;
            }
            const costoDomicilio_el = document.querySelector(`.costoDomicilio`);
            if (typeof costoDomicilio_el !== 'undefined' && costoDomicilio_el !== null) {
                costoDomicilio_el.innerHTML = response.costoDomicilio;
            }
        });
});

bindEvent("click", ".overlay-carrito", (e) => {
    document.querySelector(".carrito").classList.remove('mostrar');
    document.querySelector(".overlay-carrito").classList.add('d-none');
    document.querySelector("body").classList.remove('overflow-hidden');
});

bindEvent("click", ".cerrar_carrito", (e) => {
    document.querySelector(".carrito").classList.remove('mostrar');
    document.querySelector(".overlay-carrito").classList.add('d-none');
    document.querySelector("body").classList.remove('overflow-hidden');

});
bindEvent("click", ".btn-agregar-productos", (e) => {
    document.querySelector(".carrito").classList.remove('mostrar');
    document.querySelector(".overlay-carrito").classList.add('d-none');
    document.querySelector("body").classList.remove('overflow-hidden');

});



bindEvent("click", ".btn-vaciar", (e) => {
    e.preventDefault();
    const url = e.target.href;
    fetch(url)
        .then((res) => res.json())
        .catch((error) => console.error("Error:", error))
        .then((response) => {
            if (response.success) {
                document.querySelector(".carrito").classList.remove('mostrar');
                document.querySelector(".overlay-carrito").classList.add('d-none');
                document.querySelector("body").classList.remove('overflow-hidden');
                document.querySelector(".cantidad-productos").classList.add("d-none");
                document.querySelector(".cantidad-productos").innerHTML = 0;
            }
        });
});

bindEvent("click", ".navbar-direccion", (e) => {
    e.preventDefault();
    let elemento = e.target;
    if (elemento.classList.contains('img-direccion')) {
        elemento = elemento.parentNode;
    }
    const url = elemento.href;
    console.log(url);
    fetch(url)
        .then((res) => res.text())
        .catch((error) => console.error("Error:", error))
        .then((text) => {
            const contenedorCarro = document.querySelector(".contenedor-ajax-direccion");
            contenedorCarro.innerHTML = text;
            setTimeout(() => {
                document.querySelector(".direccion-pop").classList.add('mostrar');
            }, 50);
            document.querySelector("body").classList.add('overflow-hidden');
        });
});


bindEvent("click", ".overlay-direccion", (e) => {
    document.querySelector(".direccion-pop").classList.remove('mostrar');
    document.querySelector(".overlay-direccion").classList.add('d-none');
    document.querySelector("body").classList.remove('overflow-hidden');
});

bindEvent("click", ".cerrar-direccion", (e) => {
    document.querySelector(".direccion-pop").classList.remove('mostrar');
    document.querySelector(".overlay-direccion").classList.add('d-none');
    document.querySelector("body").classList.remove('overflow-hidden');
});

bindEvent("change", "#direccion_g", (e) => {
    document.querySelector("#direccion").value = "";    
});

bindEvent("change", "#direccion", (e) => {
    const direccion_g_el = document.querySelector("#direccion_g");
    if (typeof direccion_g_el !== 'undefined' && direccion_g_el !== null) {
        direccion_g_el.value = "";
    }
});


bindEvent("click", ".verificarDireccion", (e) => {

    
    const direccionEscrita = document.querySelector('#direccion').value;
    const direccion_g_el = document.querySelector("#direccion_g");
    let direccionGSelect = "";
    if (typeof direccion_g_el !== 'undefined' && direccion_g_el !== null) {
        direccionGSelect = direccion_g_el.value;
    }
    
    if (direccionEscrita != "") {
        let url = 'https://maps.googleapis.com/maps/api/geocode/json?address={address}&components=country:CO&key=' + API_KEY_GEO_MAP;
        url = url.replace('{address}', encodeURIComponent(direccionEscrita));
        fetch(url)
            .then((res) => res.json())
            .catch((error) => console.error("Error:", error))
            .then((data) => {
                if (data.status == "OK") {
                    if (data.results.length > 1) {
                        if (confirm("Se encontro mas de un resultado, desea continuar?")) {
                            let resultados0 = data.results[0];
                            if (resultados0.types.indexOf("street_address") != -1) {

                                let url_verificar = document.querySelector('#url_verificar').value;
                                let data = { lat: resultados0.geometry.location.lat, lng: resultados0.geometry.location.lng, dirComp: direccionEscrita };
                                const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

                                fetch(url_verificar, {
                                    method: "POST",
                                    body: JSON.stringify(data),
                                    headers: {
                                        "X-CSRF-Token": csrfToken,
                                        "Content-Type": "application/json",
                                    },
                                })
                                    .then((res) => res.json())
                                    .catch((error) => console.error("Error:", error))
                                    .then((response) => {
                                        console.log(response);
                                        if (response.success == true) {
                                            window.location.reload();
                                        } else {
                                            alert(response.error);
                                        }
                                    });
                            }
                            else {
                                alert("Direccion invalida");
                            }
                        }
                    }
                    else {
                        let resultados0 = data.results[0];
                        if (resultados0.types.indexOf("street_address") != -1) {

                            let url_verificar = document.querySelector('#url_verificar').value;
                            let data = { lat: resultados0.geometry.location.lat, lng: resultados0.geometry.location.lng, dirComp: direccionEscrita };
                            const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

                            fetch(url_verificar, {
                                method: "POST",
                                body: JSON.stringify(data),
                                headers: {
                                    "X-CSRF-Token": csrfToken,
                                    "Content-Type": "application/json",
                                },
                            })
                                .then((res) => res.json())
                                .catch((error) => console.error("Error:", error))
                                .then((response) => {
                                    console.log(response);
                                    if (response.success == true) {
                                        window.location.reload();
                                    } else {
                                        alert(response.error);
                                    }
                                });
                        }
                        else {
                            alert("Direccion invalida");
                        }
                    }
                }
                else {
                    alert("Direccion invalida");
                }
            });
    }
    else if (direccionGSelect != "") {
        let url_verificar = document.querySelector('#url_verificar').value;
        let data = { idDir: direccionGSelect};
        const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

        fetch(url_verificar, {
            method: "POST",
            body: JSON.stringify(data),
            headers: {
                "X-CSRF-Token": csrfToken,
                "Content-Type": "application/json",
            },
        })
            .then((res) => res.json())
            .catch((error) => console.error("Error:", error))
            .then((response) => {
                console.log(response);
                if (response.success == true) {
                    window.location.reload();
                } else {
                    alert(response.error);
                }
            });
        
        
    }
    else{
        alert("Selecciona una direccion");
    }

});


bindEvent("click", "#direccion_carrito", (e) => {
    e.preventDefault();
    const url = document.querySelector("#url_pop_direccion").value;
    fetch(url)
        .then((res) => res.text())
        .catch((error) => console.error("Error:", error))
        .then((text) => {
            const contenedorCarro = document.querySelector(".contenedor-ajax-direccion");
            contenedorCarro.innerHTML = text;
            setTimeout(() => {
                document.querySelector(".direccion-pop").classList.add('mostrar');
            }, 50);
            document.querySelector("body").classList.add('overflow-hidden');
        });
});

bindEvent("click", ".btn-ingresar", (e) => {    
    let elemento = e.target;
    if (elemento.classList.contains('img-ingresar')) {
        elemento = elemento.parentNode;
    }
    if (elemento.classList.contains('span-ingresar')) {
        elemento = elemento.parentNode;
    }
    
});
bindEvent("click", ".logout-c", (e) => {    
    e.preventDefault();
    document.querySelector('#logout').submit();   
});

bindEvent("click", ".verificar-cupon", (e) => {
    e.preventDefault();
    const cupon = document.querySelector("#cupon-txt").value;
    const url = document.querySelector("#url_verificar_cupon").value + `/${cupon}`;
    fetch(url)
        .then((res) => res.json())
        .catch((error) => console.error("Error:", error))
        .then((response) => {
            const respuestaEl = document.querySelector(".respuestaCodigo");
            respuestaEl.classList.remove("d-none");
            if(response.success == true){
                respuestaEl.classList.remove("text-danger");
                respuestaEl.classList.add("text-success");
                respuestaEl.innerHTML = response.respuestaTexto;
                document.querySelector("#cupon-txt").readOnly = true;
                const btnEl = document.querySelector(".verificar-cupon");
                btnEl.innerHTML = "Quitar";
                btnEl.classList.add('quitar-cupon');
                btnEl.classList.remove('verificar-cupon');
            }
            else{
                respuestaEl.classList.add("text-danger");
                respuestaEl.classList.remove("text-success");
                respuestaEl.innerHTML = response.respuestaTexto;
            }
            const total_el = document.querySelector(`.total`);
            if (typeof total_el !== 'undefined' && total_el !== null) {
                total_el.innerHTML = response.total;
            }
            const descuento_el = document.querySelector(`.descuento`);
            if (typeof descuento_el !== 'undefined' && descuento_el !== null) {
                descuento_el.innerHTML = response.descuento;
            }
            const costoDomicilio_el = document.querySelector(`.costoDomicilio`);
            if (typeof costoDomicilio_el !== 'undefined' && costoDomicilio_el !== null) {
                costoDomicilio_el.innerHTML = response.costoDomicilio;
            }
            
            
        });
});

bindEvent("click", ".quitar-cupon", (e) => {
    e.preventDefault();
    const url = document.querySelector("#url_quitar_cupon").value;
    fetch(url)
        .then((res) => res.json())
        .catch((error) => console.error("Error:", error))
        .then((response) => {
            const respuestaEl = document.querySelector(".respuestaCodigo");
            respuestaEl.classList.add("d-none");
            const btnEl = document.querySelector(".quitar-cupon");
            btnEl.innerHTML = "Verificar";
            btnEl.classList.remove('quitar-cupon');
            btnEl.classList.add('verificar-cupon');
            document.querySelector("#cupon-txt").value = "";
            document.querySelector("#cupon-txt").readOnly = false;

            const total_el = document.querySelector(`.total`);
            if (typeof total_el !== 'undefined' && total_el !== null) {
                total_el.innerHTML = response.total;
            }
            const descuento_el = document.querySelector(`.descuento`);
            if (typeof descuento_el !== 'undefined' && descuento_el !== null) {
                descuento_el.innerHTML = response.descuento;
            }
            const costoDomicilio_el = document.querySelector(`.costoDomicilio`);
            if (typeof costoDomicilio_el !== 'undefined' && costoDomicilio_el !== null) {
                costoDomicilio_el.innerHTML = response.costoDomicilio;
            }
        });
});

bindEvent("change", "#horaPedido", (e) => {
    e.preventDefault();
    const hora = document.querySelector("#horaPedido").value;
    const url = document.querySelector("#url_cambiar_hora").value + `/${hora}`;
    fetch(url)
        .then((res) => res.json())
        .catch((error) => console.error("Error:", error))
        .then((response) => {
            const total_el = document.querySelector(`.total`);
            if (typeof total_el !== 'undefined' && total_el !== null) {
                total_el.innerHTML = response.total;
            }
            const costoDomicilio_el = document.querySelector(`.costoDomicilio`);
            if (typeof costoDomicilio_el !== 'undefined' && costoDomicilio_el !== null) {
                costoDomicilio_el.innerHTML = response.costoDomicilio;
            }
        });
});

bindEvent("click", ".mas-unidades-unico", (e) => {
    e.preventDefault();
    const unidades_el = document.querySelector("#unidades");
    let unidades_val = parseInt(unidades_el.value);
    unidades_val += 1;
    unidades_el.value = unidades_val;
    const unidades_el2 = document.querySelector(".cant-productos-unico");
    unidades_el2.innerHTML = unidades_val;
    const numero = parseInt(document.querySelector("#precioProd").value) * unidades_val;
    document.querySelector(".valor_u").innerHTML = `$ ${numero.toLocaleString('es-CO')}`;
});



bindEvent("click", ".menos-unidades-unico", (e) => {
    e.preventDefault();
    const unidades_el = document.querySelector("#unidades");
    let unidades_val = parseInt(unidades_el.value);
    unidades_val -= 1;
    if(unidades_val < 1){
        unidades_val = 1;
    }
    unidades_el.value = unidades_val;
    const unidades_el2 = document.querySelector(".cant-productos-unico");
    unidades_el2.innerHTML = unidades_val;
    const numero = parseInt(document.querySelector("#precioProd").value) * unidades_val;
    document.querySelector(".valor_u").innerHTML = `$ ${numero.toLocaleString('es-CO')}`;
});

bindEvent("click", ".btn-agregar-unico", (e) => {
    e.preventDefault();
    
    let unidades_val = parseInt(document.querySelector("#unidades").value);
    const url = document.querySelector(".btn-agregar-unico").href + `/${unidades_val}`;
    fetch(url)
        .then((res) => res.json())
        .catch((error) => console.error("Error:", error))
        .then((response) => {
            if (response.carrito.cuentaProductos > 0) {
                document.querySelector(".cantidad-productos").classList.remove("d-none");
                document.querySelector(".cantidad-productos").innerHTML = response.carrito.cuentaProductos;
            }
            const btnCarrito = document.querySelector(".btn-carrito");
            abrirCarrito(btnCarrito.href);
            document.querySelector("#unidades").value = 1;
            document.querySelector(".cant-productos-unico").innerHTML = 1;
            const numero = parseInt(document.querySelector("#precioProd").value);
            document.querySelector(".valor_u").innerHTML = `$ ${numero.toLocaleString('es-CO')}`;
        });
    
});
