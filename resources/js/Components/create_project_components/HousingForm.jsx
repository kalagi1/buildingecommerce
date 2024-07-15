import React, { useCallback, useEffect, useRef, useState } from "react";
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

function HousingForm({
  selectedTypesTitles,
  user,
  slug,
  prevStep,
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
  const [zoom, setZoom] = useState(5);
  const [center, setCenter] = useState({ lat: 39.0, lng: 35.0 }); // Coordinates for Turkey's center
  const [selectedLocation, setSelectedLocation] = useState({});
  const mapRef = useRef();

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

  useEffect(() => {
    setProjectDataFunc(
      "coordinates",
      selectedLocation.lat + "-" + selectedLocation.lng
    );
  }, [selectedLocation]);

  useEffect(() => {
    setTimeout(() => {
      setZoom(6);
    }, 2000);
  }, []);

  const onMapLoad = useCallback(
    (map) => {
      map.setCenter(center);
      map.setZoom(5);
      map.addListener("click", (e) => {
        if (zoom == 12) {
          const lat = e.latLng.lat();
          const lng = e.latLng.lng();
          setSelectedLocation({ lat, lng });
        } else {
          alert("Lütfen il,ilçe ve mahalle seçimini tamamlayınız.");
        }
      });
      setMap(map);
    },
    [
      center,
      projectData.city_id,
      projectData.county_id,
      projectData.neighborhood_id,
    ]
  );

  const setGeolocation = (cityId, countyId = null, neighborhoodId = null) => {
    var cityTemp = cities.find((city) => {
      return city.id == cityId;
    });

    if (cityId && !countyId && !neighborhoodId) {
      setZoom(8);
    } else if (cityId && countyId && !neighborhoodId) {
      setZoom(10);
    } else {
      setZoom(12);
    }

    var countyTemp = counties.find((county) => {
      return county.ilce_key == countyId;
    });
    var neighborhoodTemp = neighborhoods.find((neighborhood) => {
      return neighborhood.mahalle_id == neighborhoodId;
    });
    fromAddress(
      cityTemp.title +
        " " +
        countyTemp?.ilce_title +
        " " +
        neighborhoodTemp?.mahalle_title
    )
      .then(({ results }) => {
        setCenter(results[0].geometry.location);
      })
      .catch(console.error);
  };

  const checkLocationWithinBounds = (location) => {
    const cityBounds = {
      north: 42.0,
      south: 36.0,
      east: 45.0,
      west: 25.0,
    };

    return (
      location.lat >= cityBounds.south &&
      location.lat <= cityBounds.north &&
      location.lng >= cityBounds.west &&
      location.lng <= cityBounds.east
    );
  };

  useEffect(() => {
    setProjectDataFunc(
      "coordinates",
      `${selectedLocation.lat}-${selectedLocation.lng}`
    );
  }, [selectedLocation]);

  const onUnmount = useCallback(function callback(map) {
    setMap(null);
  }, []);

  useEffect(() => {
    setTimeout(() => {
      setZoom(5);
    }, 2000);
  }, []);

  return (
    <div>
      <div className="section-title mt-5">
        <h2>Kategori </h2>
      </div>
      <div className="card p-4 adv-flex">
        <ul className="adv-breadcrumb">
          <li className="fa fa-home"></li>
          {selectedTypesTitles.map((title, index) => (
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
          Kişisel verilerin korunması hakkında detaylı bilgiye{" "}
          <a href="https://emlaksepette.com/sayfa/kvkk-politikasi">buradan</a>{" "}
          ulaşabilirsiniz.
        </div>
        <div className="form-group">
          <label htmlFor="project_title">
            İlan Başlığı <span className="required">*</span>
          </label>
          <div className="max-character-input">
            <div className="row" style={{ alignItems: "center" }}>
              <div className="input col-md-10">
                <input
                  id="project_title"
                  value={projectData.project_title}
                  onChange={(e) => setProjectTitle(e.target.value)}
                  type="text"
                  className={`form-control advert_title ${
                    allErrors.includes("project_title") ? "error-border" : ""
                  }`}
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
            İlan Açıklaması <span className="required">*</span>
          </label>
          <EditorToolbar />
          <ReactQuill
            theme="snow"
            value={projectData.description}
            id="description"
            onChange={(e) => setProjectDataFunc("description", e)}
            modules={modules}
            formats={formats}
            className={allErrors.includes("description") ? "error-border" : ""}
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
              İl <span className="required">*</span>
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
              İlçe <span className="required">*</span>
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
              Mahalle <span className="required">*</span>
            </label>
            <select
              onChange={(e) => {
                setGeolocation(
                  projectData.city_id,
                  projectData.county_id,
                  e.target.value
                );
                setProjectDataFunc("neighborhood_id", e.target.value);
              }}
              name="neighborhood_id"
              id="neighbourhood_id"
              className={`form-control ${
                allErrors.includes("neighborhood_id") ? "error-border" : ""
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
        {isLoaded ? (
          <div className="mt-4">
            <GoogleMap
              mapContainerStyle={{ height: "300px", width: "100%" }}
              center={center}
              zoom={zoom}
              onLoad={onMapLoad}
              onUnmount={onUnmount}
              ref={mapRef}
            >
              {selectedLocation.lat && (
                <Marker position={selectedLocation} draggable />
              )}
            </GoogleMap>
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
      />
    </div>
  );
}

export default HousingForm;
