import React, { useEffect, useState } from "react";
import axios from "axios";
import { baseUrl } from "../define/variables";
import TopCreateProjectNavigator from "./create_project_components/TopCreateProjectNavigator";
import { ToastContainer, toast } from "react-toastify";
import "react-toastify/dist/ReactToastify.css";
import { Box, LinearProgress, Modal, Typography } from "@mui/material";
import TypeList2 from "./create_project_components/TypeList2";
import HousingForm from "./create_project_components/HousingForm";
import EndSectionHousing from "./create_project_components/EndSectionHousing";
import PreviewHousing from "./create_project_components/PreviewHousing";
import LoadingModal from "./LoadingModal";
import CustomModal from "./CustomModal";
import { compressToUTF16, decompressFromUTF16 } from "lz-string";

function CreateHousing(props) {
  const [step, setStep] = useState(
    () => JSON.parse(localStorage.getItem("step")) || 1
  );
  const [selectedLocation, setSelectedLocation] = useState(
    () => JSON.parse(localStorage.getItem("selectedLocation")) || {}
  );

  const [loadingStorageModalOpen, setStorageLoadingModalOpen] = useState(
    () => JSON.parse(localStorage.getItem("loadingStorageModalOpen")) || false
  );
  const [housingTypes, setHousingTypes] = useState(
    () => JSON.parse(localStorage.getItem("housingTypes")) || []
  );
  const [selectedTypes, setSelectedTypes] = useState(
    () => JSON.parse(localStorage.getItem("selectedTypes")) || []
  );
  const [fillFormData, setFillFormData] = useState(
    () => JSON.parse(localStorage.getItem("fillFormData")) || []
  );
  const [loadingModalOpen, setLoadingModalOpen] = useState(
    () => JSON.parse(localStorage.getItem("loadingModalOpen")) || false
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
  const [slug, setSlug] = useState(
    () => JSON.parse(localStorage.getItem("slug")) || ""
  );
  const [blocks, setBlocks] = useState(
    () =>
      JSON.parse(localStorage.getItem("blocks")) || [
        {
          name: "housing",
          roomCount: 1,
          rooms: [{}],
        },
      ]
  );
  const [roomCount, setRoomCount] = useState(
    () => JSON.parse(localStorage.getItem("roomCount")) || 1
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
  const [selectedTypesTitles, setSelectedTypesTitles] = useState(
    () => JSON.parse(localStorage.getItem("selectedTypesTitles")) || []
  );
  const [user, setUser] = useState(
    () => JSON.parse(localStorage.getItem("user")) || {}
  );

  // Kullanıcı bilgilerini al
  useEffect(() => {
    axios.get(baseUrl + "get_current_user").then((res) => {
      setUser(res.data.user);
    });
  }, []);

  // Tüm state değerlerini localStorage'da sakla
  useEffect(() => {
    localStorage.setItem("step", JSON.stringify(step));
  }, [step]);

  useEffect(() => {
    localStorage.setItem(
      "loadingStorageModalOpen",
      JSON.stringify(loadingStorageModalOpen)
    );
  }, [loadingStorageModalOpen]);

  useEffect(() => {
    localStorage.setItem("housingTypes", JSON.stringify(housingTypes));
  }, [housingTypes]);

  useEffect(() => {
    localStorage.setItem("selectedTypes", JSON.stringify(selectedTypes));
  }, [selectedTypes]);

  useEffect(() => {
    localStorage.setItem("fillFormData", JSON.stringify(fillFormData));
  }, [fillFormData]);

  useEffect(() => {
    localStorage.setItem("loadingModalOpen", JSON.stringify(loadingModalOpen));
  }, [loadingModalOpen]);

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
    localStorage.setItem("slug", JSON.stringify(slug));
  }, [slug]);

  useEffect(() => {
    localStorage.setItem("blocks", JSON.stringify(blocks));
  }, [blocks]);

  useEffect(() => {
    localStorage.setItem("roomCount", JSON.stringify(roomCount));
  }, [roomCount]);

  useEffect(() => {
    localStorage.setItem("selectedLocation", JSON.stringify(selectedLocation));
  }, [selectedLocation]);

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
    localStorage.setItem(
      "selectedTypesTitles",
      JSON.stringify(selectedTypesTitles)
    );
  }, [selectedTypesTitles]);

  useEffect(() => {
    localStorage.setItem("user", JSON.stringify(user));
  }, [user]);

  const convertFileToBinary = (file) => {
    return new Promise((resolve, reject) => {
      const reader = new FileReader();
      reader.readAsArrayBuffer(file); // Read the file as an ArrayBuffer
      reader.onload = () => resolve(reader.result); // Resolve with the ArrayBuffer result
      reader.onerror = (error) => reject(error); // Reject on error
    });
  };

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

  const handleStartOver = () => {
    localStorage.removeItem("step");
    localStorage.removeItem("loadingStorageModalOpen");
    localStorage.removeItem("housingTypes");
    localStorage.removeItem("selectedTypes");
    localStorage.removeItem("fillFormData");
    localStorage.removeItem("loadingModalOpen");
    localStorage.removeItem("projectData");
    localStorage.removeItem("selectedHousingType");
    localStorage.removeItem("haveBlocks");
    localStorage.removeItem("slug");
    localStorage.removeItem("blocks");
    localStorage.removeItem("roomCount");
    localStorage.removeItem("allErrors");
    localStorage.removeItem("selectedBlock");
    localStorage.removeItem("selectedRoom");
    localStorage.removeItem("anotherBlockErrors");
    localStorage.removeItem("selectedTypesTitles");
    localStorage.removeItem("user");
    setStep(1);
    setSelectedTypes([]);
    setBlocks([
      {
        name: "housing",
        roomCount: 1,
        rooms: [{}],
      },
    ]);
    setStorageLoadingModalOpen(false);
  };

  useEffect(() => {
    localStorage.setItem(
      "selectedTypesTitles",
      JSON.stringify(selectedTypesTitles)
    );
  }, [selectedTypesTitles]);

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

  const createProject = () => {
    const formDataHousing = JSON.parse(
      selectedHousingType?.housing_type?.form_json || "[]"
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
            if (slug == "satilik") {
              if (!formDataHousing?.className?.includes("project-disabled")) {
                if (
                  !formDataHousing?.className
                    ?.split(" ")
                    .includes("disabled-housing") &&
                  !formDataHousing?.className
                    ?.split(" ")
                    .includes("cover-image-by-housing-type")
                ) {
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
                if (!projectData.county_id) {
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
                          if (slug == "gunluk-kiralik") {
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
                            }
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
                              if (user.type == "1") {
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
                                }
                              } else {
                                if (!projectData.authority_certificate) {
                                  var element = document.getElementById(
                                    "authority_certificate"
                                  );
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
      }
    }

    if (blocks.length > 0) {
      formDataHousing.forEach((formDataHousing) => {
        if (
          slug == "satilik" &&
          !formDataHousing?.className
            ?.split(" ")
            .find((classx) => classx == "project-disabled") &&
          !formDataHousing?.className?.includes("only-show-project-rent") &&
          !formDataHousing?.className?.includes(
            "only-show-project-daliy-rent"
          ) &&
          !formDataHousing?.className?.includes("only-show-project-sale")
        ) {
          if (
            !formDataHousing?.className
              ?.split(" ")
              .includes("disabled-housing") &&
            !formDataHousing?.className
              ?.split(" ")
              .includes("cover-image-by-housing-type")
          ) {
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
          !formDataHousing?.className
            ?.split(" ")
            .find((classx) => classx == "project-disabled") &&
          !formDataHousing?.className?.includes("only-show-project-rent") &&
          !formDataHousing?.className?.includes(
            "only-show-project-daliy-rent"
          ) &&
          !formDataHousing?.className?.includes("only-show-project-sale")
        ) {
          if (!formDataHousing?.className?.includes("project-disabled")) {
            if (
              !formDataHousing?.className
                ?.split(" ")
                .includes("disabled-housing") &&
              !formDataHousing?.className
                ?.split(" ")
                .includes("cover-image-by-housing-type")
            ) {
              if (formDataHousing.required) {
                if (blocks.length < 1) {
                  tempErrors.push(formDataHousing.name.replace("[]", ""));
                } else {
                  if (
                    blocks[selectedBlock].rooms[selectedRoom][
                      formDataHousing.name
                    ]
                  ) {
                    console.log(
                      blocks[selectedBlock].rooms[selectedRoom][
                        formDataHousing.name
                      ]
                    );
                  }
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
        }

        if (
          slug == "kiralik" &&
          !formDataHousing?.className
            ?.split(" ")
            .find((classx) => classx == "rent-disabled") &&
          !formDataHousing?.className?.includes("only-show-project-rent") &&
          !formDataHousing?.className?.includes(
            "only-show-project-daliy-rent"
          ) &&
          !formDataHousing?.className?.includes("only-show-project-sale")
        ) {
          if (!formDataHousing?.className?.includes("project-disabled")) {
            if (
              !formDataHousing?.className
                ?.split(" ")
                .includes("disabled-housing") &&
              !formDataHousing?.className
                ?.split(" ")
                .includes("cover-image-by-housing-type")
            ) {
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
        }

        if (
          slug == "devren-kiralik" &&
          !formDataHousing?.className
            ?.split(" ")
            .find((classx) => classx == "rent-disabled") &&
          !formDataHousing?.className?.includes("only-show-project-rent") &&
          !formDataHousing?.className?.includes(
            "only-show-project-daliy-rent"
          ) &&
          !formDataHousing?.className?.includes("only-show-project-sale")
        ) {
          if (!formDataHousing?.className?.includes("project-disabled")) {
            if (
              !formDataHousing?.className
                ?.split(" ")
                .includes("disabled-housing") &&
              !formDataHousing?.className
                ?.split(" ")
                .includes("cover-image-by-housing-type")
            ) {
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
        }

        if (
          slug == "gunluk-kiralik" &&
          !formDataHousing?.className
            ?.split(" ")
            .find((classx) => classx == "daily-rent-disabled") &&
          !formDataHousing?.className?.includes("only-show-project-rent") &&
          !formDataHousing?.className?.includes(
            "only-show-project-daliy-rent"
          ) &&
          !formDataHousing?.className?.includes("only-show-project-sale")
        ) {
          if (
            !formDataHousing?.className
              ?.split(" ")
              .includes("disabled-housing") &&
            !formDataHousing?.className
              ?.split(" ")
              .includes("cover-image-by-housing-type")
          ) {
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

    if (slug != "gunluk-kiralik") {
      if (!projectData.document) {
        tempErrors.push("document");
      }

      if (user.type != "1") {
        if (!projectData.authority_certificate) {
          tempErrors.push("authority_certificate");
        }
      }
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

  const [progress, setProgress] = useState(0);

  const prepareFormDataWithBinary = async (data) => {
    const formData = new FormData();

    for (const [key, value] of Object.entries(data)) {
      if (value instanceof File) {
        const binaryData = await convertFileToBinary(value);
        formData.append(
          key,
          new Blob([binaryData], { type: value.type }),
          value.name
        );
      } else if (Array.isArray(value)) {
        for (const item of value) {
          if (item instanceof File) {
            const binaryData = await convertFileToBinary(item);
            formData.append(
              key,
              new Blob([binaryData], { type: item.type }),
              item.name
            );
          } else {
            formData.append(key, item);
          }
        }
      } else if (typeof value === "object" && value !== null) {
        for (const [subKey, subValue] of Object.entries(value)) {
          if (subValue instanceof File) {
            const binaryData = await convertFileToBinary(subValue);
            formData.append(
              `${key}[${subKey}]`,
              new Blob([binaryData], { type: subValue.type }),
              subValue.name
            );
          } else {
            formData.append(`${key}[${subKey}]`, subValue);
          }
        }
      } else {
        formData.append(key, value);
      }
    }

    return formData;
  };

  const finishCreateHousing = async () => {
    setLoadingModalOpen(true);
    setProgress(0);
    let progressInterval;

    // Start the progress bar increment
    progressInterval = setInterval(() => {
      setProgress((prev) =>
        prev < 90 ? prev + Math.floor(Math.random() * 10) + 1 : 90
      );
    }, 500);

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

    var housingTemp = 1;

    blocks.forEach((block, blockIndex) => {
      block.rooms.forEach((room, roomIndex) => {
        Object.keys(room).forEach((key) => {
          if (key == "payDecs") {
            room.payDecs.forEach((payDec, payDecIndex) => {
              formData.append(
                `room[payDecs][${payDecIndex}][price]`,
                payDec.price
              );
              formData.append(
                `room[payDecs][${payDecIndex}][date]`,
                payDec.date
              );
            });
          } else {
            if (!key.includes("imagex")) {
              formData.append(`room[${key.replace("[]", "")}]`, room[key]);
            }
          }
        });

        housingTemp++;
      });
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
    const sendData = await prepareFormDataWithBinary(formData);


    axios
      .post(baseUrl + "create_housing", sendData, {
        headers: {
          accept: "application/json",
          "Accept-Language": "en-US,en;q=0.8",
          "Content-Type": `multipart/form-data;`,
        },
      })
      .then((res) => {
        if (res.status) {
          clearInterval(progressInterval);
          setProgress(100);
          setTimeout(() => {
            setLoadingModalOpen(false);
            setStep(4);
            setFillFormData(null);
          }, 500);
        }
      })
      .catch((error) => {
        clearInterval(progressInterval);
        setLoadingModalOpen(false);
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

  const totalRoomCount = () => {
    var roomCount = 0;
    blocks.map((block) => {
      roomCount += parseInt(block.roomCount);
    });

    return roomCount;
  };

  const prevStep = () => {
    setBlocks(
      JSON.parse(localStorage.getItem("blocks")) || [
        {
          name: "housing",
          roomCount: 1,
          rooms: [{}],
        },
      ]
    );
    setStep(step - 1);
    window.scrollTo(0, 0);
  };

  const nextStep = () => {
    if (step == 1) {
      setBlocks([
        {
          name: "housing",
          roomCount: 1,
          rooms: [{}],
        },
      ]);
      setProjectData([]);
    }
    setStep(step + 1);
    window.scrollTo(0, 0);
  };
  return (
    <>
      {step == 1 ? (
        <div className="table-breadcrumb">
          <ul>
            <li>Emlak İlanı Ekle</li>
            <li>Adım Adım Kategori Seç</li>
          </ul>
        </div>
      ) : step == 2 ? (
        <div className="table-breadcrumb">
          <ul>
            <li>Emlak İlanı Ekle</li>

            <li>İlan Detayları</li>
          </ul>
        </div>
      ) : step == 3 ? (
        <div className="table-breadcrumb">
          <ul>
            <li>Emlak İlanı Ekle</li>

            <li>Önizleme</li>
          </ul>
        </div>
      ) : (
        <div className="table-breadcrumb">
          <ul>
            <li>Emlak İlanı Ekle</li>

            <li>Tebrikler</li>
          </ul>
        </div>
      )}
      <TopCreateProjectNavigator step={step} setStep={setStep} />

      {step == 1 ? (
        <TypeList2
          setSelectedTypesTitles={setSelectedTypesTitles}
          selectedTypesTitles={selectedTypesTitles}
          setSlug={setSlug}
          setSelectedHousingType={setSelectedHousingType}
          selectedHousingType={selectedHousingType}
          housingTypes={housingTypes}
          setHousingTypes={setHousingTypes}
          selectedTypes={selectedTypes}
          setSelectedTypes={setSelectedTypes}
          nextStep={nextStep}
        />
      ) : step == 2 ? (
        <HousingForm
          user={user}
          selectedLocation={selectedLocation}
          slug={slug}
          setSelectedLocation={setSelectedLocation}
          prevStep={prevStep}
          anotherBlockErrors={anotherBlockErrors}
          selectedTypesTitles={selectedTypesTitles}
          selectedBlock={selectedBlock}
          setSelectedBlock={setSelectedBlock}
          selectedRoom={selectedRoom}
          selectedTypes={selectedTypes}
          setSelectedRoom={setSelectedRoom}
          allErrors={allErrors}
          createProject={createProject}
          nextStep={nextStep}
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
        <PreviewHousing
          projectData={projectData}
          setProjectDataFunc={setProjectDataFunc}
          allErrors={allErrors}
          prevStep={prevStep}
          selectedTypes={selectedTypes}
          blocks={blocks}
          createProject={createProject}
          finishCreateHousing={finishCreateHousing}
          fillFormData={fillFormData}
        />
      ) : (
        <EndSectionHousing />
      )}
      {loadingModalOpen && (
        <LoadingModal open={loadingModalOpen} progress={progress} />
      )}

      <CustomModal
        isOpen={loadingStorageModalOpen}
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
    </>
  );
}
export default CreateHousing;
