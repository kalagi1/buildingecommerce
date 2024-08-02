import React, { useState, useEffect, useRef, useCallback } from "react";
import { Alert } from "@mui/material";
import ReactQuill from "react-quill";
import "react-quill/dist/quill.snow.css";
import axios from "axios";
import { GoogleMap, Marker, useJsApiLoader } from "@react-google-maps/api";
import { fromAddress, setDefaults } from "react-geocode";
import EditorToolbar, { modules, formats } from "./QuilToolbar";
import HousingRoom from "./HousingRoom";
import FileUpload from "./FileUpload";
import FinishArea from "./FinishArea";
import { baseUrl } from "../../define/variables";
import { FALSE } from "sass";
function HousingForm({
  selectedTypesTitles,
  selectedLocation,
  setSelectedLocation,
  user,
  slug,
  prevStep,
  nextStep,
  anotherBlockErrors,
  selectedBlock,
  setSelectedBlock,
  selectedRoom,
  setSelectedRoom,
  projectData,
  allErrors,
  setProjectDataFunc,
  haveBlocks,
  setHaveBlocks,
  roomCount,
  setRoomCount,
  blocks,
  setBlocks,
  selectedHousingType,
  setProjectData,
  createProject,
}) {
  const [cities, setCities] = useState([]);
  const [counties, setCounties] = useState([]);
  const [neighborhoods, setNeighborhoods] = useState([]);
  const [map, setMap] = useState(null);
  const [error, setError] = useState(null);

  const [isShow, setIsShow] = useState(false);
  const [bounds, setBounds] = useState(null); // State for bounds

  const [zoom, setZoom] = useState(5);
  const [center, setCenter] = useState({ lat: 39.0, lng: 35.0 }); // Coordinates for Turkey's center

  const mapRef = useRef(null);
  const isShowRef = useRef(isShow);
  const rectangleRef = useRef(null);
  const clickListenerRef = useRef(null);
  const markerRef = useRef(null);

  useEffect(() => {
    isShowRef.current = isShow;
  }, [isShow]);

  useEffect(() => {
    axios.get(`${baseUrl}cities`).then((res) => setCities(res.data.data));

    setDefaults({
      key: "AIzaSyB-ip8tV3D9tyRNS8RMUwxU8n7mCJ9WCl0",
      language: "en",
      region: "es",
    });
  }, []);

  const fetchCounties = (cityId) =>
    axios
      .get(`${baseUrl}counties?city_id=${cityId}`)
      .then((res) => setCounties(res.data.data));

  const fetchNeighborhoods = (countyId) =>
    axios
      .get(`${baseUrl}neighborhoods?county_id=${countyId}`)
      .then((res) => setNeighborhoods(res.data.data));

  useEffect(() => {
    if (projectData.city_id) {
      fetchCounties(projectData.city_id);
    }
  }, [projectData.city_id]);

  useEffect(() => {
    if (projectData.county_id) {
      fetchNeighborhoods(projectData.county_id);
    }
  }, [projectData.county_id]);
  const dotNumberFormat = (number) => {
    if (
      number
        .replace(".", "")
        .replace(".", "")
        .replace(".", "")
        .replace(".", "") !=
      parseInt(
        number
          .replace(".", "")
          .replace(".", "")
          .replace(".", "")
          .replace(".", "")
          .replace(".", "")
      )
    ) {
      return "";
    } else {
      var inputValue = number.replace(/\D/g, "");
      inputValue = inputValue.replace(/\B(?=(\d{3})+(?!\d))/g, ".");

      return inputValue;
    }
  };

  useEffect(() => {
    axios.get(baseUrl + "cities").then((res) => {
      setCities(res.data.data);
    });

    setDefaults({
      key: "AIzaSyB-ip8tV3D9tyRNS8RMUwxU8n7mCJ9WCl0", // Your API key here.
      language: "en", // Default language for responses.
      region: "es", // Default region for responses.
    });
  }, []);

  const getCounties = (cityId) => {
    axios.get(baseUrl + "counties?city_id=" + cityId).then((res) => {
      setCounties(res.data.data);
    });
  };

  const getNeighborhoods = (countyId) => {
    axios.get(baseUrl + "neighborhoods?county_id=" + countyId).then((res) => {
      setNeighborhoods(res.data.data);
    });
  };

  const label = { inputProps: { "aria-label": "Switch demo" } };

  const containerStyle = {
    width: "100%",
    height: "400px",
  };

  const { isLoaded } = useJsApiLoader({
    id: "google-map-script",
    googleMapsApiKey: "AIzaSyB-ip8tV3D9tyRNS8RMUwxU8n7mCJ9WCl0",
    language: "tr",
  });

  const setGeolocation = (cityId, countyId = null, neighborhoodId = null) => {
    const cityTemp = cities.find((city) => city.id == cityId);
    const countyTemp = counties.find((county) => county.ilce_key == countyId);
    const neighborhoodTemp = neighborhoods.find(
      (neighborhood) => neighborhood.mahalle_id == neighborhoodId
    );

    console.log("City:", cityTemp);
    console.log("County:", countyTemp);
    console.log("Neighborhood:", neighborhoodTemp);

    if (cityId) {
      setZoom(8);
    }

    if (countyId) {
      setZoom(10);
    }

    fromAddress(
      `${cityTemp.title} ${countyTemp?.ilce_title || ""} ${
        neighborhoodTemp?.mahalle_title || ""
      }`
    )
      .then(({ results }) => {
        console.log("Geolocation Results:", results);

        if (neighborhoodTemp) {
          setIsShow(true);
          setZoom(12);
          console.log("Neighborhood exists, isShow set to true");
        } else {
          setIsShow(false);
          console.log("Neighborhood does not exist, isShow set to false");
        }

        setCenter(results[0].geometry.location);
        console.log("Map Center:", results[0].geometry.location);

        // Define bounds based on the geolocation results
        const northeast = results[0].geometry.bounds.northeast;
        const southwest = results[0].geometry.bounds.southwest;
        const bounds = new google.maps.LatLngBounds(southwest, northeast);
        setBounds(bounds);
      })
      .catch(console.error);
  };

  const onMapLoad = useCallback(
    (map) => {
      mapRef.current = map;
      map.setCenter(center);
      map.setZoom(zoom);
    },
    [center, zoom]
  );

  useEffect(() => {
    if (mapRef.current) {
      mapRef.current.setCenter(center);
      mapRef.current.setZoom(zoom);
    }
  }, [center, zoom]);

  // useEffect(() => {
  //     const map = mapRef.current;
  //     if (!map) return;

  //     if (bounds) {
  //         if (rectangleRef.current) {
  //             rectangleRef.current.setMap(null); // Remove previous rectangle
  //         }
  //         rectangleRef.current = new google.maps.Rectangle({
  //             bounds: bounds,
  //             map: mapRef.current,
  //             fillColor: '#FF0000',
  //             fillOpacity: 0.2,
  //             strokeColor: '#FF0000',
  //             strokeOpacity: 0.8,
  //             strokeWeight: 2,
  //             clickable: true, // Ensure it doesn't intercept clicks
  //           });

  //         map.fitBounds(bounds);
  //     }
  // }, [bounds]);

  useEffect(() => {
    const map = mapRef.current;
    if (!map) return;

    const handleClick = (e) => {
      const latLng = e.latLng;
      const lat = latLng.lat();
      const lng = latLng.lng();
      
      // Check if the clicked location is within Turkey's boundaries
      const isWithinTurkey = lat >= 35.8 && lat <= 42.1 && lng >= 25.8 && lng <= 44.8;

      // Check if projectData has required fields
      if (!projectData.city_id || !projectData.county_id || !projectData.neighbourhood_id) {
        setError("Lütfen il, ilçe ve mahalle seçimini tamamlayınız.");
        return;
      }

      if (isWithinTurkey) {
        setSelectedLocation({ lat, lng });

        if (markerRef.current) {
          markerRef.current.setMap(null);
        }

        markerRef.current = new google.maps.Marker({
          position: { lat, lng },
          map: map,
          title: "Selected Location",
        });
        setError(null);
      } else {
        setError("Türkiye sınırları içinde bir nokta seçiniz.");
      }
    };

    // Remove previous listener if exists
    if (clickListenerRef.current) {
      google.maps.event.removeListener(clickListenerRef.current);
    }

    // Add new listener
    clickListenerRef.current = map.addListener("click", handleClick);

    // Cleanup function to remove listener on component unmount or if map changes
    return () => {  
      if (clickListenerRef.current) {
        google.maps.event.removeListener(clickListenerRef.current);
      }
    };
  }, [mapRef.current, projectData]);
  
  useEffect(() => {
    console.log(selectedLocation)
    setProjectDataFunc(
      "coordinates",
      `${selectedLocation.lat}-${selectedLocation.lng}`
    );

  }, [selectedLocation]);

  const onUnmount = useCallback(function callback(map) {
    setMap(null);
  }, []);

  return (
    <>
      {" "}
      <div>
        <div className="section-title mt-5">
          <h2>Kategori </h2>
        </div>
        <div className="card p-4 adv-flex">
          <ul className="adv-breadcrumb">
            <li className="fa fa-home"></li>

            {selectedTypesTitles &&
              selectedTypesTitles.map((title, index) => (
                <React.Fragment key={index}>
                  <li>{title}</li>
                  {index < selectedTypesTitles.length - 1 && (
                    <li>
                      <i className="fa fa-chevron-right"></i>
                    </li>
                  )}
                </React.Fragment>
              ))}
          </ul>
          <button
            className="btn btn-link"
            style={{ backgroundColor: "transparent" }}
            onClick={prevStep}
          >
            Değiştir
          </button>
        </div>
        <div className="section-title mt-5">
          <h2>İlan Detayları </h2>
        </div>
        <div className="card p-4">
          <div className="add-classified-note mb-3">
            Kişisel verilerin korunması kapsamındaki bilgilere ve aydınlatma
            yükümlülüğü metnine{" "}
            <a
              href="https://private.emlaksepette.com/sayfa/kvkk-politikasi"
              target="_blank"
            >
              buradan
            </a>{" "}
            ulaşabilirsiniz.
          </div>
          <div className="form-group">
            <label htmlFor="project_title">
              İlan Başlığı <span className="required-span">*</span>
            </label>
            <div className="max-character-input">
              <div className="row" style={{ alignItems: "center" }}>
                <div className="input col-md-10">
                  <input
                    id="project_title"
                    value={projectData.project_title}
                    onChange={(e) =>
                      setProjectDataFunc("project_title", e.target.value)
                    }
                    type="text"
                    className={`form-control ilan_baslik ${
                      allErrors.includes("project_title") ? "error-border" : ""
                    }`}
                    maxLength={70}
                  />
                </div>
                <div className="col-md-2">
                  <label className="max-character">
                    {projectData.project_title?.length || 0}/70
                  </label>
                </div>
              </div>
            </div>
          </div>
          <div className="form-group">
            <label htmlFor="description">
              İlan Açıklaması <span className="required-span">*</span>
            </label>
            <EditorToolbar />
            <ReactQuill
              theme="snow"
              value={projectData.description}
              id="description"
              onChange={(e) => setProjectDataFunc("description", e)}
              modules={modules}
              formats={formats}
              className={
                allErrors.includes("description") ? "error-border" : ""
              }
            />
          </div>
        </div>

        <HousingRoom
          slug={slug}
          anotherBlockErrors={anotherBlockErrors}
          selectedBlock={selectedBlock}
          setSelectedBlock={setSelectedBlock}
          selectedRoom={selectedRoom}
          setSelectedRoom={setSelectedRoom}
          selectedHousingType={selectedHousingType}
          allErrors={allErrors}
          blocks={blocks}
          setBlocks={setBlocks}
          roomCount={roomCount}
          setRoomCount={setRoomCount}
        />

        <div className="section-title mt-5">
          <h2>Adres Bilgileri</h2>
        </div>
        <div className="card p-4">
          <div className="row">
            <div className="col-md-4">
              <label htmlFor="city_id">
                İl <span className="required-span">*</span>
              </label>
              <select
                value={projectData.city_id}
                onChange={(e) => {
                  setGeolocation(e.target.value);
                  setProjectDataFunc("city_id", e.target.value);
                  fetchCounties(e.target.value);
                }}
                name="city_id"
                id="city_id"
                className={`form-control ${
                  allErrors.includes("city_id") ? "error-border" : ""
                }`}
              >
                <option value="">İl Seç</option>
                {cities.map((city) => (
                  <option key={city.id} value={city.id}>
                    {city.title}
                  </option>
                ))}
              </select>
            </div>
            <div className="col-md-4">
              <label htmlFor="county_id">
                İlçe <span className="required-span">*</span>
              </label>
              <select
                value={projectData.county_id}
                onChange={(e) => {
                  setGeolocation(projectData.city_id, e.target.value);
                  setProjectDataFunc("county_id", e.target.value);
                  fetchNeighborhoods(e.target.value);
                }}
                name="county_id"
                id="county_id"
                className={`form-control ${
                  allErrors.includes("county_id") ? "error-border" : ""
                }`}
              >
                <option value="">İlçe Seç</option>
                {counties.map((county) => (
                  <option key={county.ilce_key} value={county.ilce_key}>
                    {county.ilce_title}
                  </option>
                ))}
              </select>
            </div>
            <div className="col-md-4">
              <label htmlFor="neighbourhood_id">
                Mahalle <span className="required-span">*</span>
              </label>
              <select
                onChange={(e) => {
                  setGeolocation(
                    projectData.city_id,
                    projectData.county_id,
                    e.target.value
                  );
                  setProjectDataFunc("neighbourhood_id", e.target.value);
                }}
                value={projectData.neighbourhood_id}
                name="neighbourhood_id"
                id="neighbourhood_id"
                className={`form-control ${
                  allErrors.includes("neighbourhood_id") ? "error-border" : ""
                }`}
              >
                <option value="">Mahalle Seç</option>
                {neighborhoods.map((neighborhood) => (
                  <option
                    key={neighborhood.mahalle_id}
                    value={neighborhood.mahalle_id}
                  >
                    {neighborhood.mahalle_title}
                  </option>
                ))}
              </select>
            </div>
          </div>
          {  !selectedLocation ? (
            <Alert
              severity="error"
              className="mt-3"
              style={{ alignItems: "center" }}
            >
              Harita üzerine bir konum seçin
            </Alert>
          ) : (
            ""
          )}
          {error ? (
            <Alert
              severity="error"
              className="mt-3"
              style={{ alignItems: "center" }}
            >
              {error}
            </Alert>
          ) : (
            ""
          )}
          {isLoaded ? (
            <div className="mt-4 ">
              <GoogleMap
                mapContainerStyle={{ height: "300px", width: "100%" }}
                center={center}
                id="map"
                zoom={zoom}
                onLoad={onMapLoad}
                onUnmount={onUnmount}
                options={{
                  gestureHandling: "greedy",
                }}
                ref={mapRef}
              >
                {selectedLocation && (
                  <Marker position={selectedLocation} draggable />
                )}
              </GoogleMap>
              {
                allErrors.includes('coordinates') ? 
                  <div className="error-area mt-2">Lütfen harita üzerinde bir konum seçiniz</div>
                : ""
              }
            </div>
          ) : (
            <div className="loading-spinner">Harita Yükleniyor...</div>
          )}
        </div>

        <div class="section-title mt-5">
          <h2>Kapak Fotoğrafı</h2>
        </div>
        <FileUpload
          requiredType={["png", "jpeg", "gif", "jpg"]}
          accept={"image/png, image/gif, image/jpeg"}
          projectData={projectData}
          setProjectData={setProjectData}
          allErrors={allErrors}
          fileName={"cover_image"}
          setProjectDataFunc={setProjectDataFunc}
          multiple={false}
        />
        <div class="section-title mt-5">
          <h2>İlan Galerisi</h2>
        </div>
        <FileUpload
          requiredType={["png", "jpeg", "gif", "jpg"]}
          accept={"image/png, image/gif, image/jpeg"}
          projectData={projectData}
          setProjectData={setProjectData}
          allErrors={allErrors}
          fileName={"gallery"}
          setProjectDataFunc={setProjectDataFunc}
          multiple={true}
        />

        {slug != "gunluk-kiralik" ? (
          <>
            <div class="section-title mt-5">
              <h2>Tapu Belgesi / Noter Sözleşmesi</h2>
            </div>
            <FileUpload
              requiredType={"pdf"}
              accept={"application/pdf"}
              projectData={projectData}
              document={1}
              setProjectData={setProjectData}
              fileName={"document"}
              allErrors={allErrors}
              setProjectDataFunc={setProjectDataFunc}
              title="Tapu Belgesi / Noter Sözleşmesi"
              multiple={false}
            />
            {user.type != "1" ? (
              <>
                <div class="section-title mt-5">
                  <h2>Yetki Belgesi</h2>
                </div>
                <FileUpload
                  requiredType={["pdf"]}
                  accept={"application/pdf"}
                  projectData={projectData}
                  document={1}
                  setProjectData={setProjectData}
                  fileName={"authority_certificate"}
                  allErrors={allErrors}
                  setProjectDataFunc={setProjectDataFunc}
                  title="Yetki Belgesi"
                  multiple={false}
                />
              </>
            ) : (
              ""
            )}
          </>
        ) : (
          ""
        )}
        <FinishArea
          projectData={projectData}
          setProjectDataFunc={setProjectDataFunc}
          allErrors={allErrors}
          createProject={createProject}
          nextStep={nextStep}
        />
      </div>
    </>
  );
}

export default HousingForm;
