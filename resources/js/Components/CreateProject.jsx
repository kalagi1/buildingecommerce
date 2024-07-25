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
import { compressToUTF16, decompressFromUTF16 } from "lz-string";

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
  const [projectData, setProjectData] = useState(() => {
    const storedData = localStorage.getItem("projectData");
    if (storedData) {
      try {
        const decompressedData = decompressFromUTF16(storedData);
        return JSON.parse(decompressedData);
      } catch (e) {
        console.error("Error decompressing or parsing data:", e);
        return {};
      }
    }
    return {};
  });
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
    try {
      const compressedData = compressToUTF16(JSON.stringify(projectData));
      localStorage.setItem("projectData", compressedData);
    } catch (e) {
      console.error("Error compressing or storing data:", e);
    }
  }, [projectData]);
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
    localStorage.setItem("blocks", JSON.stringify(blocks));
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

  const setProjectDataFunc = async (key, value) => {
    let newValue = value;

    // Convert files to Binary
    if (value instanceof File) {
      newValue = await convertFileToBinary(value);
    } else if (Array.isArray(value)) {
      newValue = await Promise.all(
        value.map(async (item) => {
          if (item instanceof File) {
            return await convertFileToBinary(item);
          }
          return item;
        })
      );
    } else if (typeof value === "object" && value !== null) {
      newValue = {};
      for (const [subKey, subValue] of Object.entries(value)) {
        if (subValue instanceof File) {
          newValue[subKey] = await convertFileToBinary(subValue);
        } else {
          newValue[subKey] = subValue;
        }
      }
    }

    setProjectData((prev) => {
      const newProjectData = { ...prev, [key]: newValue };
      try {
        const compressedData = compressToUTF16(JSON.stringify(newProjectData));
        localStorage.setItem("projectData", compressedData);
      } catch (e) {
        console.error("Error compressing or storing data:", e);
      }
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
    const storedData = localStorage.getItem("projectData");
    if (storedData) {
      try {
        const decompressedData = decompressFromUTF16(storedData);
        const parsedData = JSON.parse(decompressedData);

        // Decode Binary data for files
        decodeBinaryData(parsedData).then((decodedData) => {
          setProjectData(decodedData);
        });
      } catch (e) {
        console.error("Error decompressing or parsing data:", e);
      }
    }
  }, []);

  useEffect(() => {
    localStorage.setItem("blocks", JSON.stringify(blocks));
  }, [blocks]);

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

    localStorage.removeItem("formGenerated");
    localStorage.removeItem("updatedRoomCount");
    localStorage.removeItem("selectedAccordion");
    localStorage.removeItem("checkedItems");
    localStorage.removeItem("payDecOpen");
    localStorage.removeItem("rendered");
    localStorage.removeItem("validationErrors");
    localStorage.removeItem("selectedLocation");
  };
  const convertFileToBinary = (file) => {
    return new Promise((resolve, reject) => {
      const reader = new FileReader();
      reader.onload = () => {
        resolve(reader.result); // This is the binary data
      };
      reader.onerror = (error) => {
        reject(error);
      };
      reader.readAsArrayBuffer(file); // Read file as binary
    });
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
  
    for (const [key, value] of Object.entries(projectData)) {
      if (value instanceof File) {
        // Convert file to binary
        const binaryData = await convertFileToBinary(value);
        formData.append(key, binaryData);
      } else if (Array.isArray(value)) {
        value.forEach((data, index) => {
          if (data instanceof File) {
            // Convert file to binary
            convertFileToBinary(data).then((binaryData) => {
              formData.append(`${key}[${index}]`, binaryData);
            });
          } else {
            formData.append(`${key}[${index}]`, data);
          }
        });
      } else {
        formData.append(key, value);
      }
    }
  
    blocks.forEach((block, blockIndex) => {
      formData.append(`blocks[${blockIndex}][name]`, block.name);
      formData.append(`blocks[${blockIndex}][roomCount]`, block.roomCount);
    });
  
    formData.append("haveBlocks", haveBlocks);
    formData.append("totalRoomCount", totalRoomCount());
    selectedTypes.forEach((data, index) => {
      formData.append(`selectedTypes[${index}]`, data);
    });
  
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
  
        for (const block of blocks) {
          for (const room of block.rooms) {
            const formDataRoom = new FormData();
            formDataRoom.append("project_id", res.data.project.id);
            formDataRoom.append("room_order", housingTemp);
  
            for (const [key, value] of Object.entries(room)) {
              if (key === "payDecs") {
                value.forEach((payDec, index) => {
                  formDataRoom.append(
                    `room[payDecs][${index}][price]`,
                    payDec.price
                  );
                  formDataRoom.append(
                    `room[payDecs][${index}][date]`,
                    payDec.date
                  );
                });
              } else if (value instanceof File) {
                // Convert file to binary
                const binaryData = await convertFileToBinary(value);
                formDataRoom.append(`room[${key.replace("[]", "")}]`, binaryData);
              } else {
                formDataRoom.append(`room[${key.replace("[]", "")}]`, value);
              }
            }
  
            const callCreateRoom = () => {
              return new Promise((resolve) => {
                setTimeout(async () => {
                  await createRoomAsync(formDataRoom);
                  resolve(); // Resolve promise when room creation is done
                }, roomIndex * 1000); // Add delay between rooms
              });
            };
  
            requestPromises.push(callCreateRoom());
            housingTemp++; // Increment room order
          }
        }
  
        await Promise.all(requestPromises);
        clearInterval(progressInterval);
        setProgress(100); // Set progress to 100% when all requests are complete
        setLoadingModalOpen(false);
        setStep(4);
        setFillFormData(null);
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
