//Váriaveis Maps
var map, infoWindow, infoWindow2, infoWindow3, geocoder, directions, directionsRenderer, autocomplete;

//Váriaveis de conteúdo HTML
var contentElement, radios, searchInput, btnL, btnR;

//Váriaveis de controle HTML/JS
var list = [], control_index = 0, already = false;

//Váriaveis de resultado de consulta Google Maps
var targetLatLng, lastPos, targetName;

//Marcadores
let markers = [];


function initMap() {

if(!already){
    justifyElements();
    //init

    mapOptions = {
        center: {
            lat: -23.55275046762937,
            lng: -46.39954183007937
        },
        zoom: 17,
    }






    map = new google.maps.Map(document.getElementById("map_draw"), mapOptions);
    search = document.getElementById("pesquisaEndereco");
    radios = document.getElementsByName("options");
    btnL = document.getElementById("btn_left");
    btnR = document.getElementById("btn_right");
    directions = new google.maps.DirectionsService();
    directionsRenderer = new google.maps.DirectionsRenderer();

    infoWindow = new google.maps.InfoWindow();
    infoWindow2 = new google.maps.InfoWindow();
    geocoder = new google.maps.Geocoder();
    const locationButton = document.createElement("button");

    directionsRenderer.setMap(map);


    locationButton.textContent = "Minha localização";
    locationButton.classList.add("btn-outline-primary");
    locationButton.style.width = "10%";
    locationButton.style.height = "4rem";
    locationButton.style.fontSize = "17px";

    map.controls[google.maps.ControlPosition.BOTTOM_CENTER].push(locationButton);

    locationButton.addEventListener("click", () => {
        goToCurrentLocation();
    });

    updateCurrentLocation();
    codeAddress(null);
    draw_direction();
    //console.log(targetLatLng.lat+" "+lastPos.lat);


    //Input de pesquisa


    const searchOptions = {
        fields: ["formatted_address", "geometry", "name"],
        strictBounds: false,
        types: ["establishment"],
    };

    autocomplete = new google.maps.places.Autocomplete(search, searchOptions);

    autocomplete.bindTo("bounds", map);

    autocomplete.addListener("place_changed", () => {

        const place = autocomplete.getPlace();

        if (!place.geometry || !place.geometry.location) {
            window.alert("Sem detalhes disponíveis para a busca: '" + place.name + "'");
            return;
        }

        if (place.geometry.viewport) {
            setMapOnAll(null);
            markers = [];
            lastPos = place.geometry.location;
            var marker = new google.maps.Marker({
                map: map,
                position: lastPos,
            });
            markers.push(marker);
            map.fitBounds(place.geometry.viewport);
            goToCurrentLocation();
            codeAddress(null);
            draw_direction();
        } else {
            
        }

    });
    already = true;
}else{
    justifyElements();
}
}



function handleLocationError(browserHasGeolocation, infoWindow, pos) {
    infoWindow.setPosition(pos);
    infoWindow.setContent(
        browserHasGeolocation
            ? "Erro: O serviço de Geolocalização falhou"
            : "Erro: Seu navegador não suporta o serviço de Geolocalização"
    );
    infoWindow.open(map);
}




function setMapOnAll(map) {
    for (let i = 0; i < markers.length; i++) {
        markers[i].setMap(map);
    }
}



function justifyElements() {

    contentElement = document.getElementById("card_content");
    contentElement.classList.toggle("hide_content")


}
function setEndereco(objectEndereco) {
    list.push(objectEndereco);
}

function codeAddress(address) {

    //Atualizando marcadores
    setMapOnAll(null);
    markers = [];

    //Criando marcador e movendo câmera para a localização da empresa
    if (address == null || address == "") {
        var address = list[control_index].logradouro + " - " + list[control_index].bairro + ", " + list[control_index].estado;
    }
    geocoder.geocode({ 'address': address }, function (results, status) {
        if (status == 'OK') {
            targetLatLng = results[0].geometry.location
            mark_destiny();

        } else {
            alert('Geocode não obteve êxito pelo seguinte motivo: ' + status);
        }
    });
}
function mark_destiny(){
    
    var marker = new google.maps.Marker({
        map: map,
        position: targetLatLng,
        title: list[control_index].nome,
        label: list[control_index].nome.substring(0, 1)
    });
    marker.addListener("click", () => {
        const cameraOptions = {
            center: marker.getPosition(),
            heading: 0,
            tilt: 0,
            zoom: 19
        };
        map.moveCamera(cameraOptions);
        infoWindow3 = new google.maps.InfoWindow();
        infoWindow3.setPosition(marker.getPosition());
        infoWindow3.setContent(list[control_index].nome);
        infoWindow3.open(map);
      });
    markers.push(marker);

}

function arrow_left() {
    setTimeout(function () {
        control_index -= 1;
        if (control_index < 0) {
            control_index = list.length - 1;
        }
        codeAddress(null);
        draw_direction();
    }, 650)
}

function arrow_right() {
    setTimeout(function () {
        control_index += 1;
        if (control_index >= list.length) {
            control_index = 0;
        }
        codeAddress(null);
        draw_direction();
    }, 650)
}

function draw_direction() {
    setMapOnAll(null);
    markers = [];
    if (lastPos != null && lastPos != "" && targetLatLng != null && targetLatLng != "") {

        mark_destiny();
        var travelMode = null;

        if (radios[0].checked) {
            travelMode = google.maps.TravelMode.TRANSIT
        }
        if (radios[1].checked) {
            travelMode = google.maps.TravelMode.DRIVING
        }
        if (radios[2].checked) {
            travelMode = google.maps.TravelMode.WALKING
        }
        if (radios[3].checked) {
            travelMode = google.maps.TravelMode.BICYCLING
        }

        routeOptions = {
            origin: lastPos,
            destination: targetLatLng,
            travelMode: travelMode,
            unitSystem: google.maps.UnitSystem.METRIC
        }

        directions.route(routeOptions).then((response) => {
            directionsRenderer.setDirections(response);
            infoWindow2.setPosition(targetLatLng);
            infoWindow2.setContent("'" + list[control_index].nome + "'  aproximadamente:" + response.routes[0].legs[0].distance.value + " metros (" + parseFloat(response.routes[0].legs[0].distance.value / 1000).toFixed(1) + "km)");
            infoWindow2.open(map);
        })
            .catch((e) => window.alert("Directions request failed due to " + e));;
        return true;
    } else {
        //alert("Sistema de localização iniciado!");
    }
}

function updateCurrentLocation() {
    setMapOnAll(null);
    markers = [];
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(
            (position) => {
                const pos = {
                    lat: position.coords.latitude,
                    lng: position.coords.longitude,
                };
                lastPos = pos;

            },
            () => {
                handleLocationError(true, infoWindow, map.getCenter());
            }
        );
    } else {
        handleLocationError(false, infoWindow, map.getCenter());
    }
}

function goToCurrentLocation() {
    setMapOnAll(null);
    markers = [];
    if (lastPos == null) {
        updateCurrentLocation()
    } else {
        const cameraOptions = {
            center: lastPos,
            heading: 0,
            tilt: 0,
            zoom: 18
        };

        infoWindow.setPosition(lastPos);
        infoWindow.setContent("Sua localização");
        infoWindow.open(map);
        map.moveCamera(cameraOptions)
    }
}

/**function reset(){
    control_index = 0;
    setMapOnAll(null);
    markers = [];
}**/



