import { Alert, FormControl, Switch } from "@mui/material";
import ReactQuill from "react-quill";
import "react-quill/dist/quill.snow.css";
import React, { useCallback, useEffect, useRef, useState } from "react";
import EditorToolbar, { modules, formats } from "./QuilToolbar";
import BlockRooms from "./BlockRooms";
import Rooms from "./Rooms";
import axios, { all } from "axios";
import { baseUrl } from "../../define/variables";
import { GoogleMap, Marker, useJsApiLoader } from "@react-google-maps/api";
import { fromAddress, setDefaults } from "react-geocode";
import FileUpload from "./FileUpload";
import FinishArea from "./FinishArea";
function ProjectForm({
  selectedTypesTitles,
  errorMessages,
  slug,
  selectedTypes,
  formDataHousing,
  anotherBlockErrors,
  selectedBlock,
  setSelectedBlock,
  selectedRoom,
  setSelectedRoom,
  projectData,
  allErrors,
  prevStep,
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
  const [fullEnded, setFullEnded] = useState(false);
  const [zoom, setZoom] = useState(4);
  const [mapRef, setMapRef] = useState();
  const [center, setCenter] = useState({
    lat: 37.874641,
    lng: 32.493156,
  });

  const { isLoaded } = useJsApiLoader({
    id: "google-map-script",
    googleMapsApiKey: "AIzaSyB-ip8tV3D9tyRNS8RMUwxU8n7mCJ9WCl0",
    language: "tr",
  });

  const [selectedLocation, setSelectedLocation] = useState({});
  const setProjectTitle = (projectTitle) => {
    if (projectTitle.length <= 70) {
      setProjectDataFunc("project_title", projectTitle);
    }
  };

  useEffect(() => {
    var tempErrors = [];
    if (blocks.length > 0) {
      blocks.forEach((block, blockIndex) => {
        for (var i = 0; i < block.roomCount; i++) {
          if (blocks[blockIndex].rooms[i]) {
            formDataHousing.forEach((formDataHousing) => {
              if (!formDataHousing?.className?.includes("project-disabled")) {
                if (formDataHousing?.required) {
                  if (blocks.length < 1) {
                    tempErrors.push(formDataHousing?.name?.replace("[]", ""));
                  } else {
                    if (!blocks[blockIndex].rooms[i][formDataHousing.name]) {
                      tempErrors.push(
                        formDataHousing?.name?.replace("[]", "") +
                          blockIndex +
                          i
                      );
                    }
                  }
                }
              }
            });
          } else {
            formDataHousing.forEach((formDataHousing) => {
              tempErrors.push(
                formDataHousing?.name?.replace("[]", "") + blockIndex + i
              );
            });
          }
        }
      });

      if (tempErrors.length == 0) {
        setFullEnded(true);
      } else {
        setFullEnded(false);
      }
    } else {
      setFullEnded(false);
    }
  }, [blocks]);

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

  useEffect(() => {
    setTimeout(() => {
      mapRef?.setZoom(6);
      console.log("qwe");
      setZoom(6);
    }, 1000);
  }, [fullEnded]);

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

  const onLoad = useCallback(function callback(map) {
    // This is just an example of getting and using the map instance!!! don't just blindly copy!
    const bounds = new window.google.maps.LatLngBounds(center);
    map.fitBounds(bounds);
    map.addListener("click", (e) => {
      const lat = e.latLng.lat();
      const lng = e.latLng.lng();
      setSelectedLocation({ lat, lng });
    });
    setMapRef(map);
    setMap(map);
  }, []);

  useEffect(() => {
    setProjectDataFunc(
      "coordinates",
      selectedLocation.lat + "-" + selectedLocation.lng
    );
  }, [selectedLocation]);

  const onUnmount = useCallback(function callback(map) {
    setMap(null);
  }, []);

  const controlText = {
    roadmap: "Harita",
    satellite: "Uydu",
  };

  const mapTypeControlOptions = {
    mapTypeIds: ["roadmap", "satellite"],
    mapTypeIdsCustom: {
      roadmap: controlText.roadmap,
      satellite: controlText.satellite,
    },
  };

  return (
    <div>
      <div className="section-title mt-5">
        <h2>Kategori </h2>
      </div>
      <div className="card p-4 adv-flex">
        <ul className="adv-breadcrumb">
          <li className="fa fa-home"></li>
          {selectedTypesTitles.map((selectedTypeTitle) => {
            return (
              <>
                <li>{selectedTypeTitle} </li>
                <li>
                  <i className="fa fa-chevron-right"></i>
                </li>
              </>
            );
          })}
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
            href="https://emlaksepette.com/sayfa/kvkk-politikasi"
            target="_blank"
          >
            buradan
          </a>{" "}
          ulaşabilirsiniz.
        </div>
        <div className="form-group">
          <label htmlFor="">
            Proje Adı <span className="required">*</span>
          </label>
          <div className="max-character-input">
            <div className="row" style={{ alignItems: "center" }}>
              <div className="input col-md-10">
                <input
                  id="project_title"
                  value={projectData.project_title}
                  onChange={(e) => {
                    setProjectTitle(e.target.value);
                  }}
                  type="text"
                  className={
                    "form-control ilan_baslik " +
                    (allErrors.includes("project_title") ? "error-border" : "")
                  }
                  maxLength={70}
                />
              </div>
              <div className="col-md-2">
                <label className="max-character" htmlFor="">
                  {projectData.project_title
                    ? projectData.project_title.length
                    : 0}
                  /70
                </label>
              </div>
            </div>
          </div>
        </div>
        <div className="form-group">
          <label htmlFor="">
            Proje Açıklaması <span className="required">*</span>
          </label>
          <EditorToolbar />
          <ReactQuill
            theme="snow"
            value={projectData.description}
            id="description"
            onChange={(e) => {
              setProjectDataFunc("description", e);
            }}
            modules={modules}
            formats={formats}
            className={allErrors.includes("description") ? "error-border" : ""}
          />
        </div>
      </div>
      <div className="section-title mt-5">
        <h2>Proje Genel Bilgileri </h2>
      </div>
      <div className="card p-3 mb-4 mt-4">
        <div className="htmlform-group">
          <div className="row">
            <div className="col-md-6">
              <label htmlfor="">Yapımcı Firma</label>
              <div className="icon-input">
                <div className="icon-area">
                  <svg
                    class="svg-inline--fa fa-building"
                    aria-hidden="true"
                    focusable="false"
                    data-prefix="fas"
                    data-icon="building"
                    role="img"
                    xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 384 512"
                    data-fa-i2svg=""
                  >
                    <path
                      fill="currentColor"
                      d="M336 0C362.5 0 384 21.49 384 48V464C384 490.5 362.5 512 336 512H240V432C240 405.5 218.5 384 192 384C165.5 384 144 405.5 144 432V512H48C21.49 512 0 490.5 0 464V48C0 21.49 21.49 0 48 0H336zM64 272C64 280.8 71.16 288 80 288H112C120.8 288 128 280.8 128 272V240C128 231.2 120.8 224 112 224H80C71.16 224 64 231.2 64 240V272zM176 224C167.2 224 160 231.2 160 240V272C160 280.8 167.2 288 176 288H208C216.8 288 224 280.8 224 272V240C224 231.2 216.8 224 208 224H176zM256 272C256 280.8 263.2 288 272 288H304C312.8 288 320 280.8 320 272V240C320 231.2 312.8 224 304 224H272C263.2 224 256 231.2 256 240V272zM80 96C71.16 96 64 103.2 64 112V144C64 152.8 71.16 160 80 160H112C120.8 160 128 152.8 128 144V112C128 103.2 120.8 96 112 96H80zM160 144C160 152.8 167.2 160 176 160H208C216.8 160 224 152.8 224 144V112C224 103.2 216.8 96 208 96H176C167.2 96 160 103.2 160 112V144zM272 96C263.2 96 256 103.2 256 112V144C256 152.8 263.2 160 272 160H304C312.8 160 320 152.8 320 144V112C320 103.2 312.8 96 304 96H272z"
                    ></path>
                  </svg>
                </div>
                <input
                  type="text"
                  value={projectData.create_company}
                  onChange={(e) => {
                    setProjectDataFunc("create_company", e.target.value);
                  }}
                  className="create_company"
                />
              </div>
            </div>
            <div className="col-md-6">
              <label htmlfor="">Toplam Proje Alanı (M2)</label>
              <div className="icon-input">
                <div className="icon-area">
                  <svg
                    class="svg-inline--fa fa-square"
                    aria-hidden="true"
                    focusable="false"
                    data-prefix="fas"
                    data-icon="square"
                    role="img"
                    xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 448 512"
                    data-fa-i2svg=""
                  >
                    <path
                      fill="currentColor"
                      d="M0 96C0 60.65 28.65 32 64 32H384C419.3 32 448 60.65 448 96V416C448 451.3 419.3 480 384 480H64C28.65 480 0 451.3 0 416V96z"
                    ></path>
                  </svg>
                </div>
                <input
                  type="text"
                  value={projectData.total_project_area}
                  onChange={(e) => {
                    setProjectDataFunc(
                      "total_project_area",
                      dotNumberFormat(e.target.value)
                    );
                  }}
                  className="total_project_area price-only"
                />
              </div>
            </div>
            <div className="col-md-6 mt-1">
              <label htmlfor="">Ada Bilgisi</label>
              <div className="icon-input">
                <div className="icon-area">
                  <svg
                    class="svg-inline--fa fa-square"
                    aria-hidden="true"
                    focusable="false"
                    data-prefix="fas"
                    data-icon="square"
                    role="img"
                    xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 448 512"
                    data-fa-i2svg=""
                  >
                    <path
                      fill="currentColor"
                      d="M0 96C0 60.65 28.65 32 64 32H384C419.3 32 448 60.65 448 96V416C448 451.3 419.3 480 384 480H64C28.65 480 0 451.3 0 416V96z"
                    ></path>
                  </svg>
                </div>
                <input
                  type="text"
                  value={projectData.island}
                  onChange={(e) => {
                    setProjectDataFunc("island", e.target.value);
                  }}
                  className="total_project_area create_company"
                />
              </div>
            </div>
            <div className="col-md-6 mt-1">
              <label htmlfor="">Parsel Bilgisi</label>
              <div className="icon-input">
                <div className="icon-area">
                  <svg
                    class="svg-inline--fa fa-square"
                    aria-hidden="true"
                    focusable="false"
                    data-prefix="fas"
                    data-icon="square"
                    role="img"
                    xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 448 512"
                    data-fa-i2svg=""
                  >
                    <path
                      fill="currentColor"
                      d="M0 96C0 60.65 28.65 32 64 32H384C419.3 32 448 60.65 448 96V416C448 451.3 419.3 480 384 480H64C28.65 480 0 451.3 0 416V96z"
                    ></path>
                  </svg>
                </div>
                <input
                  type="text"
                  value={projectData.parcel}
                  onChange={(e) => {
                    setProjectDataFunc("parcel", e.target.value);
                  }}
                  className="total_project_area price-only"
                />
              </div>
            </div>

            <div className="col-md-6 mt-2" id="start_date_id">
              <label htmlfor="">Başlangıç Tarihi</label>
              <div className="icon-input">
                <div className="icon-area">
                  <svg
                    class="svg-inline--fa fa-calendar-days"
                    aria-hidden="true"
                    focusable="false"
                    data-prefix="fas"
                    data-icon="calendar-days"
                    role="img"
                    xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 448 512"
                    data-fa-i2svg=""
                  >
                    <path
                      fill="currentColor"
                      d="M160 32V64H288V32C288 14.33 302.3 0 320 0C337.7 0 352 14.33 352 32V64H400C426.5 64 448 85.49 448 112V160H0V112C0 85.49 21.49 64 48 64H96V32C96 14.33 110.3 0 128 0C145.7 0 160 14.33 160 32zM0 192H448V464C448 490.5 426.5 512 400 512H48C21.49 512 0 490.5 0 464V192zM64 304C64 312.8 71.16 320 80 320H112C120.8 320 128 312.8 128 304V272C128 263.2 120.8 256 112 256H80C71.16 256 64 263.2 64 272V304zM192 304C192 312.8 199.2 320 208 320H240C248.8 320 256 312.8 256 304V272C256 263.2 248.8 256 240 256H208C199.2 256 192 263.2 192 272V304zM336 256C327.2 256 320 263.2 320 272V304C320 312.8 327.2 320 336 320H368C376.8 320 384 312.8 384 304V272C384 263.2 376.8 256 368 256H336zM64 432C64 440.8 71.16 448 80 448H112C120.8 448 128 440.8 128 432V400C128 391.2 120.8 384 112 384H80C71.16 384 64 391.2 64 400V432zM208 384C199.2 384 192 391.2 192 400V432C192 440.8 199.2 448 208 448H240C248.8 448 256 440.8 256 432V400C256 391.2 248.8 384 240 384H208zM320 432C320 440.8 327.2 448 336 448H368C376.8 448 384 440.8 384 432V400C384 391.2 376.8 384 368 384H336C327.2 384 320 391.2 320 400V432z"
                    ></path>
                  </svg>
                </div>
                <input
                  type="date"
                  value={projectData.start_date}
                  onChange={(e) => {
                    if (e.target.value.length <= 10) {
                      setProjectDataFunc("start_date", e.target.value);
                    }
                  }}
                  className={
                    "start_date " +
                    (allErrors.includes("start_date") ? "error-border" : "")
                  }
                />
              </div>
              <div className="error-under-input">
                {errorMessages.start_date ? errorMessages.start_date : ""}
              </div>
            </div>

            <div className="col-md-6 mt-2" id="end_date_id">
              <label htmlfor="">Bitiş Tarihi</label>
              <div className="icon-input">
                <div className="icon-area">
                  <svg
                    class="svg-inline--fa fa-calendar-days"
                    aria-hidden="true"
                    focusable="false"
                    data-prefix="fas"
                    data-icon="calendar-days"
                    role="img"
                    xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 448 512"
                    data-fa-i2svg=""
                  >
                    <path
                      fill="currentColor"
                      d="M160 32V64H288V32C288 14.33 302.3 0 320 0C337.7 0 352 14.33 352 32V64H400C426.5 64 448 85.49 448 112V160H0V112C0 85.49 21.49 64 48 64H96V32C96 14.33 110.3 0 128 0C145.7 0 160 14.33 160 32zM0 192H448V464C448 490.5 426.5 512 400 512H48C21.49 512 0 490.5 0 464V192zM64 304C64 312.8 71.16 320 80 320H112C120.8 320 128 312.8 128 304V272C128 263.2 120.8 256 112 256H80C71.16 256 64 263.2 64 272V304zM192 304C192 312.8 199.2 320 208 320H240C248.8 320 256 312.8 256 304V272C256 263.2 248.8 256 240 256H208C199.2 256 192 263.2 192 272V304zM336 256C327.2 256 320 263.2 320 272V304C320 312.8 327.2 320 336 320H368C376.8 320 384 312.8 384 304V272C384 263.2 376.8 256 368 256H336zM64 432C64 440.8 71.16 448 80 448H112C120.8 448 128 440.8 128 432V400C128 391.2 120.8 384 112 384H80C71.16 384 64 391.2 64 400V432zM208 384C199.2 384 192 391.2 192 400V432C192 440.8 199.2 448 208 448H240C248.8 448 256 440.8 256 432V400C256 391.2 248.8 384 240 384H208zM320 432C320 440.8 327.2 448 336 448H368C376.8 448 384 440.8 384 432V400C384 391.2 376.8 384 368 384H336C327.2 384 320 391.2 320 400V432z"
                    ></path>
                  </svg>
                </div>
                <input
                  type="date"
                  value={projectData.end_date}
                  onChange={(e) => {
                    if (e.target.value.length <= 10) {
                      setProjectDataFunc("end_date", e.target.value);
                    }
                  }}
                  className={
                    "end_date " +
                    (allErrors.includes("end_date") ? "error-border" : "")
                  }
                />
              </div>
              <div className="error-under-input">
                {errorMessages.end_date ? errorMessages.end_date : ""}
              </div>
            </div>
          </div>
        </div>
      </div>
      <div className="section-title mt-5">
        <h2>Bu Projede Bloklar Var Mı? </h2>
      </div>
      <div className="card p-3 mb-4 mt-4">
        <label htmlFor="">
          <Switch
            {...label}
            defaultChecked={false}
            onChange={() => {
              setHaveBlocks(!haveBlocks);
              setBlocks([]);
            }}
            checked={haveBlocks}
          />
          Evet
        </label>
      </div>

      <div className="mb-3">
        {haveBlocks ? (
          <BlockRooms
            slug={slug}
            selectedTypes={selectedTypes}
            formDataHousing={formDataHousing}
            anotherBlockErrors={anotherBlockErrors}
            selectedBlock={selectedBlock}
            setSelectedBlock={setSelectedBlock}
            selectedRoom={selectedRoom}
            setSelectedRoom={setSelectedRoom}
            allErrors={allErrors}
            selectedHousingType={selectedHousingType}
            blocks={blocks}
            setBlocks={setBlocks}
            roomCount={roomCount}
            setRoomCount={setRoomCount}
          />
        ) : (
          <Rooms
            slug={slug}
            selectedTypes={selectedTypes}
            formDataHousing={formDataHousing}
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
        )}
      </div>
      <div
        className={"alert alert-danger mt-2 " + (fullEnded ? "d-none" : "")}
        style={{ color: "#fff" }}
      >
        Tüm ilan bilgilerini doldurmadığınız sürece diğer alanlara geçiş
        yapamazsınız. Lütfen bilgileri doldurmaya devam edin; tamamladıkça diğer
        alanlar otomatik olarak açılacaktır.
      </div>

      <div className={fullEnded ? "" : "d-none"}>
        <span className="section-title">Adres Bilgileri</span>
        <div className="card">
          <div className="row px-5 py-4">
            <div className="col-md-4">
              <label for="">
                İl <span className="required">*</span>
              </label>
              <select
                value={projectData.city_id}
                onChange={(e) => {
                  setGeolocation(e.target.value);
                  setProjectDataFunc("city_id", e.target.value);
                  getCounties(e.target.value);
                }}
                name="city_id"
                id="city_id"
                className={
                  "form-control " +
                  (allErrors.includes("city_id") ? "error-border" : "")
                }
              >
                <option value="">İl Seç</option>
                {cities.map((city) => {
                  return <option value={city.id}>{city.title}</option>;
                })}
              </select>
            </div>
            <div className="col-md-4">
              <label for="">
                İlçe <span className="required">*</span>
              </label>
              <select
                value={projectData.county_id}
                onChange={(e) => {
                  setGeolocation(projectData.city_id, e.target.value);
                  setProjectDataFunc("county_id", e.target.value);
                  getNeighborhoods(e.target.value);
                }}
                name="county_id"
                id="county_id"
                className={
                  "form-control " +
                  (allErrors.includes("city_id") ? "error-border" : "")
                }
              >
                <option value="">İlçe Seç</option>
                {counties.map((county) => {
                  return (
                    <option value={county.ilce_key}>{county.ilce_title}</option>
                  );
                })}
              </select>
            </div>
            <div className="col-md-4">
              <label for="">
                Mahalle <span className="required">*</span>
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
                name="neighbourhood_id"
                id="neighbourhood_id"
                className={
                  "form-control " +
                  (allErrors.includes("neighbourhood_id") ? "error-border" : "")
                }
              >
                <option value="">Mahalle Seç</option>
                {neighborhoods.map((neighborhood) => {
                  return (
                    <option value={neighborhood.mahalle_id}>
                      {neighborhood.mahalle_title}
                    </option>
                  );
                })}
              </select>
            </div>
          </div>
        </div>
        <div>
          {allErrors.includes("coordinates") ? (
            <Alert severity="error">Harita üzerine bir konum seçin</Alert>
          ) : (
            ""
          )}
          {isLoaded ? (
            <GoogleMap
              zoom={zoom}
              id="map"
              mapContainerStyle={containerStyle}
              center={center}
              onLoad={onLoad}
              ref={mapRef}
              onUnmount={onUnmount}
              options={{
                gestureHandling: "greedy",
              }}
              mapTypeControlOptions={mapTypeControlOptions}
            >
              {/* Child components, such as markers, info windows, etc. */}
              {selectedLocation && <Marker position={selectedLocation} />}
            </GoogleMap>
          ) : (
            <></>
          )}
        </div>
        <FileUpload
          requiredType={["png", "gif", "jpeg", "jpg"]}
          accept={"image/png, image/gif, image/jpeg"}
          projectData={projectData}
          setProjectData={setProjectData}
          allErrors={allErrors}
          fileName={"cover_image"}
          title="Kapak Fotoğrafı"
          setProjectDataFunc={setProjectDataFunc}
          multiple={false}
        />
        <FileUpload
          requiredType={["png", "gif", "jpeg", "jpg"]}
          accept={"image/png, image/gif, image/jpeg"}
          projectData={projectData}
          setProjectData={setProjectData}
          allErrors={allErrors}
          fileName={"gallery"}
          title="Proje Galerisi"
          setProjectDataFunc={setProjectDataFunc}
          multiple={true}
        />
        <FileUpload
          requiredType={["png", "gif", "jpeg", "jpg"]}
          accept={"image/png, image/gif, image/jpeg"}
          projectData={projectData}
          setProjectData={setProjectData}
          allErrors={allErrors}
          fileName={"situations"}
          setProjectDataFunc={setProjectDataFunc}
          title="Vaziyet & Kat Planı"
          multiple={true}
        />
        <FileUpload
          requiredType={["pdf"]}
          accept={"*"}
          projectData={projectData}
          document={1}
          setProjectData={setProjectData}
          fileName={"document"}
          allErrors={allErrors}
          setProjectDataFunc={setProjectDataFunc}
          title="Ruhsat Belgesi / Tapu Belgesi"
          multiple={false}
        />
        <FinishArea
          allErrors={allErrors}
          projectData={projectData}
          setProjectDataFunc={setProjectDataFunc}
          createProject={createProject}
        />
      </div>
    </div>
  );
}
export default ProjectForm;
