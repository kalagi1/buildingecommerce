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

function CreateHousing(props) {
  const [step, setStep] = useState(1);
  const [loading, setLoading] = useState(0);
  const [housingTypes, setHousingTypes] = useState([]);
  const [selectedTypes, setSelectedTypes] = useState([]);
  const [fillFormData, setFillFormData] = useState([]);
  const [loadingModalOpen, setLoadingModalOpen] = useState(false);

  const [projectData, setProjectData] = useState({});
  const [selectedHousingType, setSelectedHousingType] = useState({});
  const [haveBlocks, setHaveBlocks] = useState(false);
  const [slug, setSlug] = useState("");

  const [blocks, setBlocks] = useState([
    {
      name: "housing",
      roomCount: 1,
      rooms: [{}],
    },
  ]);

  const [roomCount, setRoomCount] = useState(1);
  const [allErrors, setAllErrors] = useState([]);
  const [selectedBlock, setSelectedBlock] = useState(0);
  const [selectedRoom, setSelectedRoom] = useState(0);
  const [anotherBlockErrors, setAnotherBlockErrors] = useState(0);
  const [selectedTypesTitles, setSelectedTypesTitles] = useState([]);
  const [user, setUser] = useState({});
  const setProjectDataFunc = (key, value) => {
    setProjectData({
      ...projectData,
      [key]: value,
    });
  };

  useEffect(() => {
    axios.get(baseUrl + "get_current_user").then((res) => {
      setUser(res.data.user);
    });
  }, []);

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
      let requestPromises = [];
      setFillFormData(formData);
      setStep(3);
    }
  };
  const [progress, setProgress] = useState(0);

  const finishCreateHousing = () => {
    setLoadingModalOpen(true);
    setProgress(0);
    let progressInterval;

    // Start the progress bar increment
    progressInterval = setInterval(() => {
      setProgress((prev) =>
        prev < 90 ? prev + Math.floor(Math.random() * 10) + 1 : 90
      );
    }, 500); // Increase progress every half a second

    axios
      .post(baseUrl + "create_housing", fillFormData, {
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
          }, 500); // Close modal after a short delay
        }
      })
      .catch((error) => {
        clearInterval(progressInterval);
        setLoadingModalOpen(false);
        toast.error(error.message);
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
  const prevStep = () => {
    setStep(step - 1);
  };
  const nextStep = () => {
    setStep(step + 1);
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
          slug={slug}
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

      {/* <Modal
        open={loadingModal}
        onClose={() => {
          setLoadingModal(false);
        }}
        aria-labelledby="modal-modal-title"
        aria-describedby="modal-modal-description"
      >
        <Box sx={style}>
          <h2>İlanınız oluşturuluyor</h2>
          <p>
            Lütfen işlem tamamlanana kadar tarayıcıyı ve bilgisayarı kapatmayın.
          </p>
          <LinearProgressWithLabel value={1} />
        </Box>
      </Modal> */}
      <LoadingModal open={loadingModalOpen} progress={progress} />

      <ToastContainer />
    </>
  );
}
export default CreateHousing;
