import React, { useEffect, useState } from "react";
import TypeList from "./create_project_components/TypeList";
import ProjectForm from "./create_project_components/ProjectForm";
import axios from "axios";
import { baseUrl } from "../define/variables";
import EndSection from "./create_project_components/EndSection";
import TopCreateProjectNavigator from "./create_project_components/TopCreateProjectNavigator";
import { ToastContainer, toast } from "react-toastify";
import "react-toastify/dist/ReactToastify.css";
import { Block } from "@mui/icons-material";
import { Box, LinearProgress, Modal, Typography } from "@mui/material";
import PreviewHousing from "./create_project_components/PreviewHousing";
import PreveiwProject from "./create_project_components/PreviewProject";
import PreviewProject from "./create_project_components/PreviewProject";
import LoadingModal from "./LoadingModal";
import CustomModal from "./CustomModal";

function CreateProject(props) {
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
  const [projectData, setProjectData] = useState(
    () => JSON.parse(localStorage.getItem("projectData")) || {}
  );
  const [selectedHousingType, setSelectedHousingType] = useState(
    () => JSON.parse(localStorage.getItem("selectedHousingType")) || {}
  );
  const [haveBlocks, setHaveBlocks] = useState(
    () => JSON.parse(localStorage.getItem("haveBlocks")) || false
  );
  const [blocks, setBlocks] = useState(
    () => JSON.parse(localStorage.getItem("blocks")) || []
  );
  const [roomCount, setRoomCount] = useState(
    () => JSON.parse(localStorage.getItem("roomCount")) || 0
  );
  const [allErrors, setAllErrors] = useState(
    () => JSON.parse(localStorage.getItem("allErrors")) || []
  );
  const [selectedBlock, setSelectedBlock] = useState(
    () => JSON.parse(localStorage.getItem("selectedBlock")) || null
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
    localStorage.setItem("loadingModal", JSON.stringify(loadingModal));
    localStorage.setItem("loading", JSON.stringify(loading));
    localStorage.setItem("housingTypes", JSON.stringify(housingTypes));
    localStorage.setItem("selectedTypes", JSON.stringify(selectedTypes));
    localStorage.setItem("projectData", JSON.stringify(projectData));
    localStorage.setItem("selectedHousingType", JSON.stringify(selectedHousingType));
    localStorage.setItem("haveBlocks", JSON.stringify(haveBlocks));
    localStorage.setItem("blocks", JSON.stringify(blocks));
    localStorage.setItem("roomCount", JSON.stringify(roomCount));
    localStorage.setItem("allErrors", JSON.stringify(allErrors));
    localStorage.setItem("selectedBlock", JSON.stringify(selectedBlock));
    localStorage.setItem("selectedRoom", JSON.stringify(selectedRoom));
    localStorage.setItem("anotherBlockErrors", JSON.stringify(anotherBlockErrors));
    localStorage.setItem("slug", JSON.stringify(slug));
    localStorage.setItem("errorMessages", JSON.stringify(errorMessages));
    localStorage.setItem("selectedTypesTitles", JSON.stringify(selectedTypesTitles));
    localStorage.setItem("fillFormData", JSON.stringify(fillFormData));
    localStorage.setItem("loadingModalOpen", JSON.stringify(loadingModalOpen));
    localStorage.setItem("storageLoadingModalOpen", JSON.stringify(storageLoadingModalOpen));
    localStorage.setItem("progress", JSON.stringify(progress));
  }, [
    step,
    loadingModal,
    loading,
    housingTypes,
    selectedTypes,
    projectData,
    selectedHousingType,
    haveBlocks,
    blocks,
    roomCount,
    allErrors,
    selectedBlock,
    selectedRoom,
    anotherBlockErrors,
    slug,
    errorMessages,
    selectedTypesTitles,
    fillFormData,
    loadingModalOpen,
    storageLoadingModalOpen,
    progress
  ]);

  useEffect(() => {
    const storedStep = localStorage.getItem("step");
    const storedLoadingModal = localStorage.getItem("loadingModal");
    const storedLoading = localStorage.getItem("loading");
    const storedHousingTypes = localStorage.getItem("housingTypes");
    const storedSelectedTypes = localStorage.getItem("selectedTypes");
    const storedProjectData = localStorage.getItem("projectData");
    const storedSelectedHousingType = localStorage.getItem("selectedHousingType");
    const storedHaveBlocks = localStorage.getItem("haveBlocks");
    const storedBlocks = localStorage.getItem("blocks");
    const storedRoomCount = localStorage.getItem("roomCount");
    const storedAllErrors = localStorage.getItem("allErrors");
    const storedSelectedBlock = localStorage.getItem("selectedBlock");
    const storedSelectedRoom = localStorage.getItem("selectedRoom");
    const storedAnotherBlockErrors = localStorage.getItem("anotherBlockErrors");
    const storedSlug = localStorage.getItem("slug");
    const storedErrorMessages = localStorage.getItem("errorMessages");
    const storedSelectedTypesTitles = localStorage.getItem("selectedTypesTitles");
    const storedFillFormData = localStorage.getItem("fillFormData");
    const storedLoadingModalOpen = localStorage.getItem("loadingModalOpen");
    const storedStorageLoadingModalOpen = localStorage.getItem("storageLoadingModalOpen");

    const storedProgress = localStorage.getItem("progress");

    if (storedStep) setStep(JSON.parse(storedStep));
    if (storedLoadingModal) setLoadingModal(JSON.parse(storedLoadingModal));
    if (storedLoading) setLoading(JSON.parse(storedLoading));
    if (storedHousingTypes) setHousingTypes(JSON.parse(storedHousingTypes));
    if (storedSelectedTypes) setSelectedTypes(JSON.parse(storedSelectedTypes));
    if (storedProjectData) setProjectData(JSON.parse(storedProjectData));
    if (storedSelectedHousingType) setSelectedHousingType(JSON.parse(storedSelectedHousingType));
    if (storedHaveBlocks) setHaveBlocks(JSON.parse(storedHaveBlocks));
    if (storedBlocks) setBlocks(JSON.parse(storedBlocks));
    if (storedRoomCount) setRoomCount(JSON.parse(storedRoomCount));
    if (storedAllErrors) setAllErrors(JSON.parse(storedAllErrors));
    if (storedSelectedBlock) setSelectedBlock(JSON.parse(storedSelectedBlock));
    if (storedSelectedRoom) setSelectedRoom(JSON.parse(storedSelectedRoom));
    if (storedAnotherBlockErrors) setAnotherBlockErrors(JSON.parse(storedAnotherBlockErrors));
    if (storedSlug) setSlug(JSON.parse(storedSlug));
    if (storedErrorMessages) setErrorMessages(JSON.parse(storedErrorMessages));
    if (storedSelectedTypesTitles) setSelectedTypesTitles(JSON.parse(storedSelectedTypesTitles));
    if (storedFillFormData) setFillFormData(JSON.parse(storedFillFormData));
    if (storedLoadingModalOpen) setLoadingModalOpen(JSON.parse(storedLoadingModalOpen));
    if (storedStorageLoadingModalOpen) setStorageLoadingModalOpen(JSON.parse(storedStorageLoadingModalOpen));
    if (storedProgress) setProgress(JSON.parse(storedProgress));
  }, []);

  const setProjectDataFunc = (key, value) => {
    setProjectData((prev) => {
      const newProjectData = { ...prev, [key]: value };
      localStorage.setItem("projectData", JSON.stringify(newProjectData));
      return newProjectData;
    });
  };

  useEffect(() => {
    localStorage.setItem("blocks", JSON.stringify(blocks));
  }, [blocks]);

  const prevStep = () => {
    setStep(step - 1);
  };

  const nextStep = () => {
    if (step == 1) {
      setBlocks([]);
      setProjectData([]);
    }
    setStep(step + 1);
   
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
            if (!formDataHousing?.className?.includes("project-disabled")) {
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
              if (!projectData.city_id) {
                var elementCity = document.getElementById("city_id");
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
                  !projectData.start_date
                ) {
                  var element = document.getElementById("projectGeneralForm");
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

    if (blocks.length > 0) {
      formDataHousing.forEach((formDataHousing) => {
        if (
          slug == "satilik" &&
          !formDataHousing?.className?.includes("only-show-project-rent") &&
          !formDataHousing?.className?.includes("only-show-project-daliy-rent")
        ) {
          if (!formDataHousing?.className?.includes("project-disabled")) {
            if (formDataHousing.required) {
              if (blocks.length < 1) {
                tempErrors.push(formDataHousing.name.replace("[]", ""));
              } else {
                if (
                  !blocks[selectedBlock].rooms[selectedRoom][
                    formDataHousing.name
                  ] ||
                  (blocks[selectedBlock].rooms[selectedRoom][
                    formDataHousing.name
                  ] &&
                    blocks[selectedBlock].rooms[selectedRoom][
                      formDataHousing.name
                    ] == "Seçiniz")
                ) {
                  tempErrors.push(formDataHousing.name.replace("[]", ""));
                }
              }
            }
          }
        }

        if (
          slug == "devren-satilik" &&
          !formDataHousing?.className?.includes("only-show-project-rent") &&
          !formDataHousing?.className?.includes("only-show-project-daliy-rent")
        ) {
          if (!formDataHousing?.className?.includes("project-disabled")) {
            if (formDataHousing.required) {
              if (blocks.length < 1) {
                tempErrors.push(formDataHousing.name.replace("[]", ""));
              } else {
                if (
                  !blocks[selectedBlock].rooms[selectedRoom][
                    formDataHousing.name
                  ] ||
                  (blocks[selectedBlock].rooms[selectedRoom][
                    formDataHousing.name
                  ] &&
                    blocks[selectedBlock].rooms[selectedRoom][
                      formDataHousing.name
                    ] == "Seçiniz")
                ) {
                  tempErrors.push(formDataHousing.name.replace("[]", ""));
                }
              }
            }
          }
        }

        if (
          slug == "kiralik" &&
          !formDataHousing?.className?.includes("only-show-project-sale") &&
          !formDataHousing?.className?.includes("only-show-project-daliy-rent")
        ) {
          if (!formDataHousing?.className?.includes("project-disabled")) {
            if (formDataHousing.required) {
              if (blocks.length < 1) {
                tempErrors.push(formDataHousing.name.replace("[]", ""));
              } else {
                if (
                  !blocks[selectedBlock].rooms[selectedRoom][
                    formDataHousing.name
                  ] ||
                  (blocks[selectedBlock].rooms[selectedRoom][
                    formDataHousing.name
                  ] &&
                    blocks[selectedBlock].rooms[selectedRoom][
                      formDataHousing.name
                    ] == "Seçiniz")
                ) {
                  tempErrors.push(formDataHousing.name.replace("[]", ""));
                }
              }
            }
          }
        }

        if (
          slug == "devren-kiralik" &&
          !formDataHousing?.className?.includes("only-show-project-sale") &&
          !formDataHousing?.className?.includes("only-show-project-daliy-rent")
        ) {
          if (!formDataHousing?.className?.includes("project-disabled")) {
            if (formDataHousing.required) {
              if (blocks.length < 1) {
                tempErrors.push(formDataHousing.name.replace("[]", ""));
              } else {
                if (
                  !blocks[selectedBlock].rooms[selectedRoom][
                    formDataHousing.name
                  ] ||
                  (blocks[selectedBlock].rooms[selectedRoom][
                    formDataHousing.name
                  ] &&
                    blocks[selectedBlock].rooms[selectedRoom][
                      formDataHousing.name
                    ] == "Seçiniz")
                ) {
                  tempErrors.push(formDataHousing.name.replace("[]", ""));
                }
              }
            }
          }
        }

        if (
          slug == "gunluk-kiralik" &&
          !formDataHousing?.className?.includes("only-show-project-rent") &&
          !formDataHousing?.className?.includes("only-show-project-sale")
        ) {
          if (!formDataHousing?.className?.includes("project-disabled")) {
            if (formDataHousing.required) {
              if (blocks.length < 1) {
                tempErrors.push(formDataHousing.name.replace("[]", ""));
              } else {
                if (
                  !blocks[selectedBlock].rooms[selectedRoom][
                    formDataHousing.name
                  ] ||
                  (blocks[selectedBlock].rooms[selectedRoom][
                    formDataHousing.name
                  ] &&
                    blocks[selectedBlock].rooms[selectedRoom][
                      formDataHousing.name
                    ] == "Seçiniz")
                ) {
                  tempErrors.push(formDataHousing.name.replace("[]", ""));
                }
              }
            }
          }
        }
      });
    }

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

    setAllErrors(tempErrors);

    if (tempErrors.length == 0 && anotherBlockErrorsTemp.length == 0) {
      const formData = new FormData();

      Object.keys(projectData).forEach((key) => {
        if (!key.includes("_imagex") && !key.includes("_imagesx")) {
          if (Array.isArray(projectData[key])) {
            projectData[key].forEach((data, index) => {
              formData.append(`projectData[${key}][${index}]`, data);
            });
          } else {
            formData.append(`projectData[${key}]`, projectData[key]);
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
      localStorage.setItem("fillFormData", JSON.stringify(formDataObj));
      setFillFormData(formData);
      setStep(3);
    }
  };

  
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
    console.log(storedStep);
    console.log(blocks);
    console.log(selectedBlock);

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
  };
  const finishCreateProject = () => {
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
  
    axios
      .post(baseUrl + "create_project", fillFormData, {
        headers: {
          accept: "application/json",
          "Accept-Language": "en-US,en;q=0.8",
          "Content-Type": `multipart/form-data;`,
        },
      })
      .then((res) => {
        if (res.data.status) {
          var housingTemp = 1;
          blocks.forEach((block, blockIndex) => {
            block.rooms.forEach((room, roomIndex) => {
              const formDataRoom = new FormData();
              formDataRoom.append("project_id", res.data.project.id);
              formDataRoom.append("room_order", housingTemp);
              Object.keys(room).forEach((key) => {
                if (key === "payDecs") {
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
                    await createRoomAsync(formDataRoom);
                    resolve(); // Resolve promise when room creation is done
                  }, roomIndex * 1000); // Add delay between rooms
                });
              };
  
              // Add the promise to the requestPromises array
              requestPromises.push(callCreateRoom());
  
              housingTemp++; // Increment room order
            });
          });
  
          Promise.all(requestPromises).then(() => {
            clearInterval(progressInterval);
            setProgress(100); // Set progress to 100% when all requests are complete
            setLoadingModalOpen(false);
            setStep(4);
            setFillFormData(null);
          });
        } else {
          clearInterval(progressInterval);
          setLoadingModalOpen(false);
          toast.error(
            "Bir hata oluştu. Lütfen Emlak Sepette yöneticisi ile iletişime geçiniz."
          );
        }
      })
      .catch((error) => {
        clearInterval(progressInterval);
        setLoadingModalOpen(false);
        console.log(error);
        toast.error(
          "Bir hata oluştu. Lütfen Emlak Sepette yöneticisi ile iletişime geçiniz."
        );
      });
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

  function LinearProgressWithLabel(props) {
    return (
      <Box sx={{ display: "flex", alignItems: "center" }}>
        <Box sx={{ width: "100%", mr: 1 }}>
          <LinearProgress variant="determinate" {...props} />
        </Box>
        <Box sx={{ minWidth: 35 }}>
          <Typography variant="body2" color="text.secondary">{`${Math.round(
            props.value
          )}%`}</Typography>
        </Box>
      </Box>
    );
  }

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
      {/* <Modal
        open={loadingModal}
        onClose={() => {
          setLoadingModal(false);
        }}
        aria-labelledby="modal-modal-title"
        aria-describedby="modal-modal-description"
      >
        <Box sx={style}>
          <h2>Projeniz oluşturuluyor</h2>
          <p>
            Lütfen işlem tamamlanana kadar tarayıcıyı ve bilgisayarı kapatmayın.{" "}
            <br /> Aşağıdaki bardan yüklenme durumunu takip edebilirisiniz
          </p>
          <LinearProgressWithLabel value={(loading * 100) / totalRoomCount()} />
        </Box>
      </Modal> */}

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
            Yeni İlan Ekle
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
