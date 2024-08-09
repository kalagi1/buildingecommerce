import React, { useEffect, useState } from "react";
import TypeList from "./create_project_components/TypeList";
import ProjectForm from "./create_project_components/ProjectForm";
import axios from "axios";
import { baseUrl, getLargeData, saveLargeData } from "../define/variables";
import EndSection from "./create_project_components/EndSection";
import TopCreateProjectNavigator from "./create_project_components/TopCreateProjectNavigator";
import { ToastContainer, toast } from "react-toastify";
import "react-toastify/dist/ReactToastify.css";
import { Box, LinearProgress, Modal, Typography } from "@mui/material";
import PreviewProject from "./create_project_components/PreviewProject";
import LoadingModal from "./LoadingModal";
import CustomModal from "./CustomModal";

function CreateProject(props) {

  useEffect(() => {
    
  })
  const [loadingStart,setLoadingStart] = useState(false);
  const [step, setStep] = useState(
    () => JSON.parse(localStorage.getItem("step")) || 1
  );
  const [loadingModal, setLoadingModal] = useState(
    () => JSON.parse(localStorage.getItem("loadingModal")) || false
  );
  const [loading, setLoading] = useState(
    () => JSON.parse(localStorage.getItem("loading")) || 0
  );
  const [housingTypes, setHousingTypes] = useState(
    () => JSON.parse(localStorage.getItem("housingTypes")) || []
  );
  const [selectedTypes, setSelectedTypes] = useState(
    () => JSON.parse(localStorage.getItem("selectedTypes")) || []
  );

  const [projectData, setProjectData] = useState({});

  const [selectedHousingType, setSelectedHousingType] = useState(
    () => JSON.parse(localStorage.getItem("selectedHousingType")) || {}
  );
  const [haveBlocks, setHaveBlocks] = useState(
    () => JSON.parse(localStorage.getItem("haveBlocks")) || false
  );
  const [blocks, setBlocks] = useState([]);
  const [roomCount, setRoomCount] = useState(
    () => JSON.parse(localStorage.getItem("roomCount")) || 0
  );
  const [allErrors, setAllErrors] = useState(
    () => JSON.parse(localStorage.getItem("allErrors")) || []
  );
  const [selectedBlock, setSelectedBlock] = useState(
    () => JSON.parse(localStorage.getItem("selectedBlock")) || 0
  );
  const [selectedRoom, setSelectedRoom] = useState(
    () => JSON.parse(localStorage.getItem("selectedRoom")) || 0
  );
  const [anotherBlockErrors, setAnotherBlockErrors] = useState(
    () => JSON.parse(localStorage.getItem("anotherBlockErrors")) || 0
  );
  const [slug, setSlug] = useState(
    () => JSON.parse(localStorage.getItem("slug")) || ""
  );
  const [errorMessages, setErrorMessages] = useState(
    () => JSON.parse(localStorage.getItem("errorMessages")) || []
  );
  const [selectedTypesTitles, setSelectedTypesTitles] = useState(
    () => JSON.parse(localStorage.getItem("selectedTypesTitles")) || []
  );
  const [fillFormData, setFillFormData] = useState(
    () => JSON.parse(localStorage.getItem("fillFormData")) || []
  );
  const [loadingModalOpen, setLoadingModalOpen] = useState(
    () => JSON.parse(localStorage.getItem("loadingModalOpen")) || false
  );
  const [storageLoadingModalOpen, setStorageLoadingModalOpen] = useState(
    () => JSON.parse(localStorage.getItem("storageLoadingModalOpen")) || false
  );
  const [progress, setProgress] = useState(
    () => JSON.parse(localStorage.getItem("progress")) || 0
  );
  useEffect(() => {
    localStorage.setItem("step", JSON.stringify(step));
  }, [step]);

  useEffect(() => {
    localStorage.setItem("loadingModal", JSON.stringify(loadingModal));
  }, [loadingModal]);

  useEffect(() => {
    localStorage.setItem("loading", JSON.stringify(loading));
  }, [loading]);

  useEffect(() => {
    localStorage.setItem("housingTypes", JSON.stringify(housingTypes));
  }, [housingTypes]);

  useEffect(() => {
    localStorage.setItem("selectedTypes", JSON.stringify(selectedTypes));
  }, [selectedTypes]);

  useEffect(() => {
    async function fetchData() {
      const storedData = await getLargeData('projectData');
      if (storedData) {
        setProjectData(storedData);
        setLoadingStart(true);
      } else {
        setLoadingStart(true);
      }
    }

    async function fetchData2() {
      const storedData2 = await getLargeData('blocks');
      if (storedData2) {
        console.log('Fetched Data:', storedData2);
        setBlocks(storedData2);
        setLoadingStart(true);
      } else {
        setLoadingStart(true);
      }
    }
    fetchData();
    fetchData2();
  }, []);

  useEffect(() => {
    async function saveData() {
      try {
        const newData = { ...projectData};
        await saveLargeData('projectData', newData);
      } catch (e) {
        console.log(e);
      }
    }

    if (loadingStart) {
      saveData();
    }
  }, [projectData, loadingStart]);
  

  useEffect(() => {
    localStorage.setItem(
      "selectedHousingType",
      JSON.stringify(selectedHousingType)
    );
  }, [selectedHousingType]);

  useEffect(() => {
    localStorage.setItem("haveBlocks", JSON.stringify(haveBlocks));
  }, [haveBlocks]);


  useEffect(() => {
    async function saveDataBlocks() {
      try {
        await saveLargeData('blocks', blocks);
      } catch (e) {
        console.log(e);
      }
    }

    if (loadingStart) {
      saveDataBlocks();
    }
  }, [blocks]);

  useEffect(() => {
    localStorage.setItem("roomCount", JSON.stringify(roomCount));
  }, [roomCount]);

  useEffect(() => {
    localStorage.setItem("allErrors", JSON.stringify(allErrors));
  }, [allErrors]);

  useEffect(() => {
    localStorage.setItem("selectedBlock", JSON.stringify(selectedBlock));
  }, [selectedBlock]);

  useEffect(() => {
    localStorage.setItem("selectedRoom", JSON.stringify(selectedRoom));
  }, [selectedRoom]);

  useEffect(() => {
    localStorage.setItem(
      "anotherBlockErrors",
      JSON.stringify(anotherBlockErrors)
    );
  }, [anotherBlockErrors]);

  useEffect(() => {
    localStorage.setItem("slug", JSON.stringify(slug));
  }, [slug]);

  useEffect(() => {
    localStorage.setItem("errorMessages", JSON.stringify(errorMessages));
  }, [errorMessages]);

  useEffect(() => {
    localStorage.setItem(
      "selectedTypesTitles",
      JSON.stringify(selectedTypesTitles)
    );
  }, [selectedTypesTitles]);

  useEffect(() => {
    localStorage.setItem("fillFormData", JSON.stringify(fillFormData));
  }, [fillFormData]);

  useEffect(() => {
    localStorage.setItem("loadingModalOpen", JSON.stringify(loadingModalOpen));
  }, [loadingModalOpen]);

  useEffect(() => {
    localStorage.setItem(
      "storageLoadingModalOpen",
      JSON.stringify(storageLoadingModalOpen)
    );
  }, [storageLoadingModalOpen]);

  useEffect(() => {
    localStorage.setItem("progress", JSON.stringify(progress));
  }, [progress]);

  const setProjectDataFunc = (key, value) => {
    setProjectData((prev) => {
      const newProjectData = { ...prev, [key]: value };
      return newProjectData;
    });
  };
  const getFileFromBinary = (binaryData, mimeType) => {
    return new Blob([binaryData], { type: mimeType });
  };

  const decodeBinaryData = async (data) => {
    if (data instanceof ArrayBuffer) {
      // Detect the MIME type based on the content (you may need a better way to determine this)
      const mimeType = "application/pdf"; // Example for PDFs; you might need to adjust for images
      return getFileFromBinary(data, mimeType);
    }
    if (Array.isArray(data)) {
      return Promise.all(data.map(decodeBinaryData));
    }
    if (typeof data === "object" && data !== null) {
      const result = {};
      for (const [key, value] of Object.entries(data)) {
        result[key] = await decodeBinaryData(value);
      }
      return result;
    }
    return data;
  };


  useEffect(() => {
    localStorage.setItem("selectedBlock", JSON.stringify(selectedBlock));
  }, [selectedBlock]);


  const prevStep = () => {
    setStep(step - 1);
    window.scrollTo(0, 0);
  };
  const nextStep = () => {
    if (step == 1) {
      setBlocks([]);
      setProjectData([]);
    }
    setStep(step + 1);
    window.scrollTo(0, 0);
  };

  function getCoords(elem) {
    // crossbrowser version
    if (elem && elem.getBoundingClientRect()) {
      var box = elem.getBoundingClientRect();

      var body = document.body;
      var docEl = document.documentElement;

      var scrollTop = window.pageYOffset || docEl.scrollTop || body.scrollTop;
      var scrollLeft =
        window.pageXOffset || docEl.scrollLeft || body.scrollLeft;

      var clientTop = docEl.clientTop || body.clientTop || 0;
      var clientLeft = docEl.clientLeft || body.clientLeft || 0;

      var top = box.top + scrollTop - clientTop;
      var left = box.left + scrollLeft - clientLeft;

      return { top: Math.round(top), left: Math.round(left) };
    }
  }

  const createRoom = async (data) => {
    await axios
      .post(baseUrl + "create_room", data, {
        headers: {
          accept: "application/json",
          "Accept-Language": "en-US,en;q=0.8",
          "Content-Type": `multipart/form-data;`,
        },
      })
      .then((res) => {
        setLoading(
          res.data.room_order > loading ? res.data.room_order : loading
        );
      });
  };

  const createRoomAsync = async (formData) => {
    return await createRoom(formData);
  };

  const typeCheck = (formDataHousing) => {
    if(slug == "satilik" && !formDataHousing?.className?.includes("project-disabled") && !formDataHousing?.className?.includes('project-disabled') && !formDataHousing?.className?.includes("only-show-project-rent") && !formDataHousing?.className?.includes("only-show-project-daliy-rent") && !formDataHousing?.className?.includes("only-not-show-project")){
      return true;
    }

    if(slug == "devren-satilik" && !formDataHousing?.className?.includes("project-disabled") && !formDataHousing?.className?.includes('project-disabled') && !formDataHousing?.className?.includes("only-show-project-rent") && !formDataHousing?.className?.includes("only-show-project-daliy-rent") && !formDataHousing?.className?.includes("only-not-show-project")){
      return true;
    }

    if(slug == "kiralik" && !formDataHousing?.className?.includes('rent-disabled') && !formDataHousing?.className?.includes("only-show-project-sale") && !formDataHousing?.className?.includes("only-show-project-daliy-rent") && !formDataHousing?.className?.includes("only-not-show-project")){
      return true;
    }

    if(slug == "devren-kiralik" && !formDataHousing?.className?.includes('rent-disabled') && !formDataHousing?.className?.includes("only-show-project-sale") && !formDataHousing?.className?.includes("only-show-project-daliy-rent") && !formDataHousing?.className?.includes("only-not-show-project")){
      return true;
    }

    if(slug == "gunluk-kiralik" && !formDataHousing?.className?.includes('daily-rent-disabled') && !formDataHousing?.className?.includes("only-show-project-rent") && !formDataHousing?.className?.includes("only-show-project-sale") && !formDataHousing?.className?.includes("only-not-show-project")){
      return true;
    }

    return false
  }
  console.log(projectData);
  const createProject = () => {
    var formDataHousing = JSON.parse(
      selectedHousingType?.housing_type?.form_json
    );
    var tempErrors = [];
    var anotherBlockErrorsTemp = [];
    if (!projectData.project_title) {
      tempErrors.push("project_title");
      var element = document.getElementById("project_title");
      window.scrollTo({
        top:
          getCoords(element).top -
          document.getElementById("navbarDefault").offsetHeight -
          30,
        behavior: "smooth", // Yumuşak kaydırma efekti için
      });
    } else {
      if (!projectData.description) {
        var elementDesc = document.getElementById("description");
        window.scrollTo({
          top:
            getCoords(elementDesc).top -
            document.getElementById("navbarDefault").offsetHeight -
            30,
          behavior: "smooth", // Yumuşak kaydırma efekti için
        });
      } else {
        if (blocks.length < 1) {
          if (haveBlocks) {
            anotherBlockErrorsTemp.push("Lütfen bloklarınızı oluşturun");
            anotherBlockErrorsTemp.push(
              "Bloklarınızı oluşturmak için yukarıdaki bloklar yazısının yanındaki + işaretine tıklayın"
            );
          } else {
            anotherBlockErrorsTemp.push(
              "Lütfen aşağıdan konut sayısınız giriniz ve ardından ilan formunu oluştur butonuna tıklayınız"
            );
          }
          console.log(anotherBlockErrorsTemp);
          var elementCity = document.getElementById("housing-forms");
          window.scrollTo({
            top:
              getCoords(elementCity).top -
              document.getElementById("navbarDefault").offsetHeight -
              30,
            behavior: "smooth", // Yumuşak kaydırma efekti için
          });
        } else {
          var boolCheck = false;
          formDataHousing.forEach((formDataHousing, order) => {
            if(typeCheck(formDataHousing)){
              if(formDataHousing.className.includes('--if-show-checked-')){
                var parentName = formDataHousing?.className?.split("--if-show-checked-")[1];
                if(blocks[selectedBlock].rooms[selectedRoom][parentName+'[]'] != undefined && blocks[selectedBlock].rooms[selectedRoom][parentName+'[]'] != "[]"){
                  if (1) {
                    if (!formDataHousing?.className?.split(" ").includes("cover-image-by-housing-type")) {
                      if (formDataHousing.required) {
                        if (blocks.length < 1) {
                          tempErrors.push(formDataHousing.name.replace("[]", ""));
                        } else {
                          if (
                            !blocks[selectedBlock].rooms[selectedRoom][
                              formDataHousing.name
                            ]
                          ) {
                            if (!boolCheck) {
                              var elementDesc = document.getElementById(
                                formDataHousing.name.replace("[]", "")
                              );
                              if (elementDesc) {
                                window.scrollTo({
                                  top:
                                    getCoords(elementDesc).top -
                                    document.getElementById("navbarDefault")
                                      .offsetHeight -
                                    30,
                                  behavior: "smooth", // Yumuşak kaydırma efekti için
                                });
                              }
    
                              boolCheck = true;
                            }
                          }
                        }
                      }
                    }
                  }
                }
              }else{
                if (formDataHousing.required) {
                  if (blocks.length < 1) {
                    tempErrors.push(formDataHousing.name.replace("[]", ""));
                  } else {
                    if (
                      !blocks[selectedBlock].rooms[selectedRoom][
                        formDataHousing.name
                      ]
                    ) {
                      if (!boolCheck) {
                        var elementDesc = document.getElementById(
                          formDataHousing.name.replace("[]", "")
                        );
                        window.scrollTo({
                          top:
                            getCoords(elementDesc).top -
                            document.getElementById("navbarDefault")
                              .offsetHeight -
                            30,
                          behavior: "smooth", // Yumuşak kaydırma efekti için
                        });
  
                        boolCheck = true;
                      }
                    }
                  }
                }
              }
              
            }
          });
          if (!boolCheck) {
            blocks.forEach((block, blockIndex) => {
              for (var i = 0; i < block.roomCount; i++) {
                if (!blocks[blockIndex].rooms[i]) {
                  if (haveBlocks) {
                    anotherBlockErrorsTemp.push(
                      blocks[blockIndex].name +
                        " bloğunun " +
                        (i + 1) +
                        " nolu konutunun verilerini doldurunuz"
                    );
                  } else {
                    anotherBlockErrorsTemp.push(
                      i + 1 + " nolu konutunun verilerini doldurunuz"
                    );
                  }
                }
              }
            });
            
          }else{
            if (anotherBlockErrorsTemp.length > 0) {
              var elementCity = document.getElementById("housing-forms");
              window.scrollTo({
                top:
                  getCoords(elementCity).top -
                  document.getElementById("navbarDefault").offsetHeight -
                  30,
                behavior: "smooth", // Yumuşak kaydırma efekti için
              });
            } else {
              if (
                !projectData.create_company ||
                !projectData.total_project_area ||
                !projectData.end_date ||
                !projectData.parcel ||
                !projectData.island ||
                !projectData.start_date) {
                var elementCity = document.getElementById("projectGeneralForm");
                window.scrollTo({
                  top:
                    getCoords(elementCity).top -
                    document.getElementById("navbarDefault").offsetHeight -
                    30,
                  behavior: "smooth", // Yumuşak kaydırma efekti için
                });
              } else {
                if (
                  !projectData.city_id
                ) {
                  var element = document.getElementById("city_id");
                  window.scrollTo({
                    top:
                      getCoords(element).top -
                      document.getElementById("navbarDefault").offsetHeight -
                      30,
                    behavior: "smooth", // For smooth scrolling effect
                  });
                } else if (!projectData.county_id) {
                  var element = document.getElementById("county_id");
                  window.scrollTo({
                    top:
                      getCoords(element).top -
                      document.getElementById("navbarDefault").offsetHeight -
                      30,
                    behavior: "smooth", // Yumuşak kaydırma efekti için
                  });
                } else {
                  if (!projectData.neighbourhood_id) {
                    var element = document.getElementById("neighbourhood_id");
                    window.scrollTo({
                      top:
                        getCoords(element).top -
                        document.getElementById("navbarDefault").offsetHeight -
                        30,
                      behavior: "smooth", // Yumuşak kaydırma efekti için
                    });
                  } else {
                    if (
                      !projectData.coordinates ||
                      projectData.coordinates == "undefined-undefined"
                    ) {
                      var element = document.getElementById("map");
                      window.scrollTo({
                        top:
                          getCoords(element).top -
                          document.getElementById("navbarDefault")
                            .offsetHeight -
                          40,
                        behavior: "smooth", // Yumuşak kaydırma efekti için
                      });
                    } else {
                      if (!projectData.cover_image) {
                        var element = document.getElementById("cover_image");
                        window.scrollTo({
                          top:
                            getCoords(element).top -
                            document.getElementById("navbarDefault")
                              .offsetHeight -
                            40,
                          behavior: "smooth", // Yumuşak kaydırma efekti için
                        });
                      } else {
                        if (!projectData.gallery) {
                          var element = document.getElementById("gallery");
                          window.scrollTo({
                            top:
                              getCoords(element).top -
                              document.getElementById("navbarDefault")
                                .offsetHeight -
                              40,
                            behavior: "smooth", // Yumuşak kaydırma efekti için
                          });
                        } else {
                          if (!projectData.situations) {
                            var element = document.getElementById("situations");
                            window.scrollTo({
                              top:
                                getCoords(element).top -
                                document.getElementById("navbarDefault")
                                  .offsetHeight -
                                40,
                              behavior: "smooth", // Yumuşak kaydırma efekti için
                            });
                          } else {
                            if (!projectData.document) {
                              var element = document.getElementById("document");
                              window.scrollTo({
                                top:
                                  getCoords(element).top -
                                  document.getElementById("navbarDefault")
                                    .offsetHeight -
                                  40,
                                behavior: "smooth", // Yumuşak kaydırma efekti için
                              });
                            } else {
                              if (!projectData.rules_confirm) {
                                var element =
                                  document.getElementById("finish-tick-id");
                                window.scrollTo({
                                  top:
                                    getCoords(element).top -
                                    document.getElementById("navbarDefault")
                                      .offsetHeight -
                                    40,
                                  behavior: "smooth", // Yumuşak kaydırma efekti için
                                });
                              } else {
                                var element =
                                  document.getElementById("start_date_id");

                                if (projectData.start_date) {
                                  const selectedDate = new Date(
                                    projectData.start_date
                                  );
                                  const minDate = new Date("2010-01-01");
                                  const maxDate = new Date("2050-01-01");

                                  if (selectedDate < minDate) {
                                    window.scrollTo({
                                      top:
                                        getCoords(element).top -
                                        document.getElementById("navbarDefault")
                                          .offsetHeight -
                                        40,
                                      behavior: "smooth", // Yumuşak kaydırma efekti için
                                    });
                                  } else if (selectedDate > maxDate) {
                                    window.scrollTo({
                                      top:
                                        getCoords(element).top -
                                        document.getElementById("navbarDefault")
                                          .offsetHeight -
                                        40,
                                      behavior: "smooth", // Yumuşak kaydırma efekti için
                                    });
                                  }
                                }

                                var element =
                                  document.getElementById("end_date_id");

                                if (projectData.end_date) {
                                  const selectedDate = new Date(
                                    projectData.start_date
                                  );
                                  const minDate = new Date("2010-01-01");
                                  const maxDate = new Date("2050-01-01");

                                  if (selectedDate < minDate) {
                                    window.scrollTo({
                                      top:
                                        getCoords(element).top -
                                        document.getElementById("navbarDefault")
                                          .offsetHeight -
                                        40,
                                      behavior: "smooth", // Yumuşak kaydırma efekti için
                                    });
                                  } else if (selectedDate > maxDate) {
                                    window.scrollTo({
                                      top:
                                        getCoords(element).top -
                                        document.getElementById("navbarDefault")
                                          .offsetHeight -
                                        40,
                                      behavior: "smooth", // Yumuşak kaydırma efekti için
                                    });
                                  }
                                }

                                setErrorMessages(tempErrorMessages);
                              }
                            }
                          }
                        }
                      }
                    }
                  }
                }
              }
            }
          }
        }
      }
    }

    var tempErrorMessages = {};
    if (projectData.start_date) {
      const selectedDate = new Date(projectData.start_date);
      const minDate = new Date("2010-01-01");
      const maxDate = new Date("2050-01-01");

      if (selectedDate < minDate) {
        tempErrorMessages["start_date"] =
          "Başlangıç Tarihi 2010 yılından öncesi olamaz";
        tempErrors.push("start_date");
      } else if (selectedDate > maxDate) {
        tempErrorMessages["start_date"] =
          "Başlangıç Tarihi 2050 yılından sonrası olamaz";
        tempErrors.push("start_date");
      }
    }

    if (projectData.end_date) {
      const selectedDate = new Date(projectData.end_date);
      const minDate = new Date("2010-01-01");
      const maxDate = new Date("2050-01-01");

      if (selectedDate < minDate) {
        tempErrorMessages["end_date"] =
          "Bitiş Tarihi 2010 yılından öncesi olamaz";
        tempErrors.push("end_date");
      } else if (selectedDate > maxDate) {
        tempErrorMessages["end_date"] =
          "Bitiş Tarihi 2050 yılından sonrası olamaz";
        tempErrors.push("end_date");
      }
    }

    setErrorMessages(tempErrorMessages);

    setAnotherBlockErrors(anotherBlockErrorsTemp);

    if (!projectData.description) {
      tempErrors.push("description");
    }

    if (!projectData.create_company) {
      tempErrors.push("create_company");
    }

    if (!projectData.total_project_area) {
      tempErrors.push("total_project_area");
    }

    if (!projectData.end_date) {
      tempErrors.push("end_date");
    }

    if (!projectData.parcel) {
      tempErrors.push("parcel");
    }
    if (!projectData.island) {
      tempErrors.push("island");
    }
    if (!projectData.start_date) {
      tempErrors.push("start_date");
    }

    if (!projectData.city_id) {
      tempErrors.push("city_id");
    }

    if (!projectData.county_id) {
      tempErrors.push("county_id");
    }

    if (!projectData.neighbourhood_id) {
      tempErrors.push("neighbourhood_id");
    }

    if (
      !projectData.coordinates ||
      projectData.coordinates == "undefined-undefined"
    ) {
      tempErrors.push("coordinates");
    }

    if (!projectData.cover_image) {
      tempErrors.push("cover_image");
    }

    if (!projectData.gallery) {
      tempErrors.push("gallery");
    }

    if (!projectData.situations) {
      tempErrors.push("situations");
    }

    if (!projectData.document) {
      tempErrors.push("document");
    }

    if (!projectData.rules_confirm) {
      tempErrors.push("rules_confirm");
    }
    console.log(tempErrors);

    setAllErrors(tempErrors);

    if (tempErrors.length == 0 && anotherBlockErrorsTemp.length == 0) {
      setStep(3);
    }
  };

  useEffect(() => {
    var newErrors = [];

    for(var i = 0; i < allErrors.length; i++){
      console.log(projectData[allErrors[i]],projectData,allErrors[i]);
      if(!projectData[allErrors[i]] || projectData[allErrors[i]] == undefined || projectData[allErrors[i]] == "Seçiniz" || projectData[allErrors[i]] == ""){
        newErrors.push(allErrors[i]);
      }
    }

    setAllErrors(newErrors);
  },[projectData])

  useEffect(() => {
    const savedFormData = localStorage.getItem("fillFormData");
    if (savedFormData) {
      const parsedFormData = JSON.parse(savedFormData);
      const formData = new FormData();
      Object.entries(parsedFormData).forEach(([key, value]) => {
        formData.append(key, value);
      });
      setFillFormData(formData);
    }
  }, []);

  useEffect(() => {
    const storedStep = localStorage.getItem("step");

    if (storedStep != 1 && storedStep != 4) {
      setLoadingModalOpen(false);
      setStorageLoadingModalOpen(true);
    } else {
      setStep(1);
    }
  }, []);

  const handleContinue = () => {
    const storedStep = localStorage.getItem("step");
    if (storedStep) {
      setStep(Number(storedStep));
    }
    setStorageLoadingModalOpen(false);
  };

  async function removeCache(){
    await saveLargeData('checkedItems', []);
    await saveLargeData('projectData',[]);
    await saveLargeData('blocks',[]);
  }

  const cleanCache = () => {
    

    removeCache();
    localStorage.removeItem("step");
    localStorage.removeItem("loadingModal");
    localStorage.removeItem("loading");
    localStorage.removeItem("housingTypes");
    localStorage.removeItem("selectedTypes");
    localStorage.removeItem("projectData");
    localStorage.removeItem("selectedHousingType");
    localStorage.removeItem("haveBlocks");
    localStorage.removeItem("blocks");
    localStorage.removeItem("roomCount");
    localStorage.removeItem("allErrors");
    localStorage.removeItem("selectedBlock");
    localStorage.removeItem("selectedRoom");
    localStorage.removeItem("anotherBlockErrors");
    localStorage.removeItem("slug");
    localStorage.removeItem("errorMessages");
    localStorage.removeItem("selectedTypesTitles");
    localStorage.removeItem("fillFormData");
    localStorage.removeItem("loadingModalOpen");
    localStorage.removeItem("progress");

    localStorage.removeItem("formGenerated");
    localStorage.removeItem("updatedRoomCount");
    localStorage.removeItem("selectedAccordion");
    localStorage.removeItem("checkedItems");
    localStorage.removeItem("payDecOpen");
    localStorage.removeItem("rendered");
    localStorage.removeItem("validationErrors");
    localStorage.removeItem("selectedLocation");
  }

  const handleStartOver = () => {
    setStep(1);
    setStorageLoadingModalOpen(false);
    setLoadingModal(false);
    setLoading(0);
    setHousingTypes([]);
    setSelectedTypes([]);
    setProjectData({});
    setSelectedHousingType({});
    setHaveBlocks(false);
    setBlocks([]);
    setRoomCount(0);
    setAllErrors([]);
    setSelectedBlock(null);
    setSelectedRoom(0);
    setAnotherBlockErrors(0);
    setSlug("");
    setErrorMessages([]);
    setSelectedTypesTitles([]);
    setFillFormData([]);
    setLoadingModalOpen(false);
    setProgress(0);
    removeCache();

    localStorage.removeItem("step");
    localStorage.removeItem("loadingModal");
    localStorage.removeItem("loading");
    localStorage.removeItem("housingTypes");
    localStorage.removeItem("selectedTypes");
    localStorage.removeItem("projectData");
    localStorage.removeItem("selectedHousingType");
    localStorage.removeItem("haveBlocks");
    localStorage.removeItem("blocks");
    localStorage.removeItem("roomCount");
    localStorage.removeItem("allErrors");
    localStorage.removeItem("selectedBlock");
    localStorage.removeItem("selectedRoom");
    localStorage.removeItem("anotherBlockErrors");
    localStorage.removeItem("slug");
    localStorage.removeItem("errorMessages");
    localStorage.removeItem("selectedTypesTitles");
    localStorage.removeItem("fillFormData");
    localStorage.removeItem("loadingModalOpen");
    localStorage.removeItem("progress");

    localStorage.removeItem("formGenerated");
    localStorage.removeItem("updatedRoomCount");
    localStorage.removeItem("selectedAccordion");
    localStorage.removeItem("checkedItems");
    localStorage.removeItem("payDecOpen");
    localStorage.removeItem("rendered");
    localStorage.removeItem("validationErrors");
    localStorage.removeItem("selectedLocation");
  };
  const finishCreateProject = async () => {
    setLoadingModalOpen(true);
    setProgress(0);
    let progressInterval;
    let requestPromises = [];

    // Start the progress bar increment
    progressInterval = setInterval(() => {
      setProgress((prev) =>
        prev < 90 ? prev + Math.floor(Math.random() * 10) + 1 : 90
      );
    }, 500); // Increase progress every half a second

    const formData = new FormData();
    console.log(projectData);
    Object.keys(projectData).forEach((key) => {
      if (!key.includes("_imagex") && !key.includes("_imagesx")) {
        if (Array.isArray(projectData[key])) {
          projectData[key].forEach((data, index) => {
            console.log(key,data);
            formData.append(`projectData[${key}][${index}]`, data);
          });
        } else {
          formData.append(`projectData[${key}]`, projectData[key]);
          console.log(key,projectData[key]);
        }
      }
    });

    blocks.forEach((block, blockIndex) => {
      formData.append(`blocks[${blockIndex}][name]`, block.name);
      formData.append(`blocks[${blockIndex}][roomCount]`, block.roomCount);
    });

    formData.append("haveBlocks", haveBlocks);
    formData.append("totalRoomCount", totalRoomCount());
    selectedTypes.forEach((data, index) => {
      formData.append(`selectedTypes[${index}]`, data);
    });
    const formDataObj = {};
    formData.forEach((value, key) => {
      formDataObj[key] = value;
    });
    setFillFormData(formData);

    try {
      const res = await axios.post(baseUrl + "create_project", formData, {
        headers: {
          accept: "application/json",
          "Accept-Language": "en-US,en;q=0.8",
          "Content-Type": `multipart/form-data;`,
        },
      });

      if (res.data.status) {
        var housingTemp = 1;

        blocks.forEach((block, blockIndex) => {
          block.rooms.forEach((room, roomIndex) => {
            const formDataRoom = new FormData();
            formDataRoom.append("project_id", res.data.project.id);
            formDataRoom.append("room_order", housingTemp);
            Object.keys(room).forEach((key) => {
              if (key == "payDecs") {
                room.payDecs.forEach((payDec, payDecIndex) => {
                  formDataRoom.append(
                    `room[payDecs][${payDecIndex}][price]`,
                    payDec.price
                  );
                  formDataRoom.append(
                    `room[payDecs][${payDecIndex}][date]`,
                    payDec.date
                  );
                });
              } else {
                if (!key.includes("imagex")) {
                  formDataRoom.append(
                    `room[${key.replace("[]", "")}]`,
                    room[key]
                  );
                }
              }
            });

            const callCreateRoom = () => {
              return new Promise((resolve) => {
                setTimeout(async () => {
                  const result = await createRoomAsync(formDataRoom);
                  resolve(result);
                }, roomIndex * 1000); // Odalar arasında 1 saniyelik gecikme sağlamak için roomIndex * 1000 milisaniye beklet
              });
            };

            // İşlemi requestPromises dizisine ekleyerek sırayla çağırma
            requestPromises.push(callCreateRoom());

            housingTemp++; // Oda sırasını arttırma
          });
        });
        await Promise.all(requestPromises);
        clearInterval(progressInterval);
        setProgress(100); // Set progress to 100% when all requests are complete
        setLoadingModalOpen(false);
        setStep(4);
        setFillFormData(null);
        cleanCache();
      } else {
        throw new Error("Project creation failed");
      }
    } catch (error) {
      clearInterval(progressInterval);
      setLoadingModalOpen(false);
      console.error(error);
      toast.error(
        "Bir hata oluştu. Lütfen Emlak Sepette yöneticisi ile iletişime geçiniz."
      );
    }
  };

  const style = {
    position: "absolute",
    top: "50%",
    left: "50%",
    transform: "translate(-50%, -50%)",
    width: 600,
    bgcolor: "background.paper",
    boxShadow: 24,
    p: 4,
  };

  const totalRoomCount = () => {
    var roomCount = 0;
    blocks.map((block) => {
      roomCount += parseInt(block.roomCount);
    });

    return roomCount;
  };

  return (
    <>
      {step == 1 ? (
        <div className="table-breadcrumb">
          <ul>
            <li>Proje İlanı Ekle</li>
            <li>Adım Adım Kategori Seç</li>
          </ul>
        </div>
      ) : step == 2 ? (
        <div className="table-breadcrumb">
          <ul>
            <li>Proje İlanı Ekle</li>

            <li>İlan Detayları</li>
          </ul>
        </div>
      ) : step == 3 ? (
        <div className="table-breadcrumb">
          <ul>
            <li>Proje İlanı Ekle</li>

            <li>Önizleme</li>
          </ul>
        </div>
      ) : (
        <div className="table-breadcrumb">
          <ul>
            <li>Tebrikler</li>
          </ul>
        </div>
      )}

      <TopCreateProjectNavigator step={step} setStep={setStep} />

      <LoadingModal open={loadingModalOpen} progress={progress} />
      <CustomModal
        isOpen={storageLoadingModalOpen}
        onClose={() => setStorageLoadingModalOpen(false)}
      >
        <div className="custom-modal-header">
          Kaldığın yerden devam etmek ister misin yoksa sıfırdan mı başlamak
          istersin?
        </div>
        <div className="custom-modal-buttons">
          <button className="custom-modal-button" onClick={handleContinue}>
            Devam Et
          </button>
          <button
            className="custom-modal-button custom-modal-button-secondary"
            onClick={handleStartOver}
          >
            Yeni İlan Ver
          </button>
        </div>
      </CustomModal>
      <ToastContainer />
      {step == 1 ? (
        <TypeList
          setSelectedTypesTitles={setSelectedTypesTitles}
          selectedTypesTitles={selectedTypesTitles}
          setSlug={setSlug}
          slug={slug}
          setSelectedHousingType={setSelectedHousingType}
          selectedHousingType={selectedHousingType}
          housingTypes={housingTypes}
          setHousingTypes={setHousingTypes}
          selectedTypes={selectedTypes}
          setSelectedTypes={setSelectedTypes}
          nextStep={nextStep}
        />
      ) : step == 2 ? (
        <ProjectForm
          selectedTypesTitles={selectedTypesTitles}
          errorMessages={errorMessages}
          slug={slug}
          formDataHousing={JSON.parse(
            selectedHousingType?.housing_type?.form_json
          )}
          prevStep={prevStep}
          anotherBlockErrors={anotherBlockErrors}
          selectedBlock={selectedBlock}
          selectedTypes={selectedTypes}
          setSelectedBlock={setSelectedBlock}
          selectedRoom={selectedRoom}
          setSelectedRoom={setSelectedRoom}
          allErrors={allErrors}
          createProject={createProject}
          selectedHousingType={selectedHousingType}
          blocks={blocks}
          setBlocks={setBlocks}
          roomCount={roomCount}
          setRoomCount={setRoomCount}
          haveBlocks={haveBlocks}
          setHaveBlocks={setHaveBlocks}
          setProjectData={setProjectData}
          projectData={projectData}
          setProjectDataFunc={setProjectDataFunc}
        />
      ) : step == 3 ? (
        <PreviewProject
          projectData={projectData}
          setProjectDataFunc={setProjectDataFunc}
          allErrors={allErrors}
          prevStep={prevStep}
          selectedTypes={selectedTypes}
          haveBlocks={haveBlocks}
          blocks={blocks}
          totalRoomCount={totalRoomCount}
          roomCount={roomCount}
          createProject={createProject}
          finishCreateProject={finishCreateProject}
          fillFormData={fillFormData}
        />
      ) : (
        <EndSection />
      )}
    </>
  );
}
export default CreateProject;
