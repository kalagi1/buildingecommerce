import React, { useEffect, useState } from "react";
import { dotNumberFormat, telNumberFormat } from "../../define/variables";
import {
  Accordion,
  AccordionDetails,
  AccordionSummary,
  Alert,
  Checkbox,
  FormControlLabel,
  Switch,
  Tooltip,
} from "@mui/material";
import RoomNavigator from "./RoomNavigator";
import PayDecModal from "./PayDecModal";
import { toast } from "react-toastify";

function Rooms({
  slug,
  formDataHousing,
  allErrors,
  anotherBlockErrors,
  selectedBlock,
  setSelectedBlock,
  selectedRoom,
  setSelectedRoom,
  blocks,
  setBlocks,
  roomCount,
  setRoomCount,
  selectedHousingType,
}) {


  const [validationErrors, setValidationErrors] = useState(
    () => JSON.parse(localStorage.getItem("validationErrors")) || []
  );
  const formData = JSON.parse(selectedHousingType?.housing_type?.form_json);
  const [rendered, setRendered] = useState(
    () => JSON.parse(localStorage.getItem("rendered")) || 0
  );
  const [payDecOpen, setPayDecOpen] = useState(
    () => JSON.parse(localStorage.getItem("payDecOpen")) || false
  );
  const [checkedItems, setCheckedItems] = useState(
    () => JSON.parse(localStorage.getItem("checkedItems")) || []
  );
  const [selectedAccordion, setSelectedAccordion] = useState(
    () => JSON.parse(localStorage.getItem("selectedAccordion")) || ""
  );
  const [formGenerated, setFormGenerated] = useState(
    () => JSON.parse(localStorage.getItem("formGenerated")) || false
  );
  const [updatedRoomCount, setUpdatedRoomCount] = useState(
    () => JSON.parse(localStorage.getItem("updatedRoomCount")) || 0
  );

  useEffect(() => {
    localStorage.setItem("validationErrors", JSON.stringify(validationErrors));
  }, [validationErrors]);

  useEffect(() => {
    localStorage.setItem("rendered", JSON.stringify(rendered));
  }, [rendered]);

  useEffect(() => {
    localStorage.setItem("payDecOpen", JSON.stringify(payDecOpen));
  }, [payDecOpen]);

  useEffect(() => {
    localStorage.setItem("checkedItems", JSON.stringify(checkedItems));
  }, [checkedItems]);

  useEffect(() => {
    localStorage.setItem("selectedAccordion", JSON.stringify(selectedAccordion));
  }, [selectedAccordion]);

  useEffect(() => {
    localStorage.setItem("formGenerated", JSON.stringify(formGenerated));
  }, [formGenerated]);

  useEffect(() => {
    localStorage.setItem("updatedRoomCount", JSON.stringify(updatedRoomCount));
  }, [updatedRoomCount]);

  // Formu oluşturma fonksiyonu
  const setRoomCountFunc = () => {
    if (roomCount > 0) {
      const newDefaultValues = [];
      const newCheckedItemsTemp = [];

      for (let i = 0; i < roomCount; i++) {
        if (!newDefaultValues[i]) newDefaultValues[i] = {};

        formData.forEach((data) => {
          if (data?.className?.includes("project-default-checked")) {
            newCheckedItemsTemp.push({
              roomOrder: i,
              name: data?.name?.replace("[]", ""),
            });

            newDefaultValues[i][data?.name] = [data?.values[0]?.value];
          }
        });
      }

      setCheckedItems([...checkedItems, ...newCheckedItemsTemp]);

      // Güncellenmiş form verilerini oluştur
      const updatedBlocks = [...blocks];
      if (blocks.length > 0) {
        // Oda sayısını arttır
        if (roomCount > blocks[0].roomCount) {
          for (let i = blocks[0].roomCount; i < roomCount; i++) {
            updatedBlocks[0].rooms.push({});
          }
        }
        // Oda sayısını azalt
        else if (roomCount < blocks[0].roomCount) {
          updatedBlocks[0].rooms = updatedBlocks[0].rooms.slice(0, roomCount);
        }
      } else {
        updatedBlocks.push({
          name: "none",
          roomCount,
          rooms: newDefaultValues,
        });
      }

      setBlocks(updatedBlocks);
      setSelectedBlock(0);
      setSelectedRoom(0);
      setFormGenerated(true); // Form oluşturuldu, butonu gizle
      setUpdatedRoomCount(roomCount); // Güncellenmiş oda sayısını ayarla
    } else {
      toast.error("Lütfen geçerli bir konut sayısı giriniz");
    }
  };

  // Oda sayısını güncelleme fonksiyonu
  const updateRoomCount = () => {
    if (updatedRoomCount > 0) {
      const newDefaultValues = [];
      const newCheckedItemsTemp = [];

      for (let i = 0; i < updatedRoomCount; i++) {
        if (!newDefaultValues[i]) newDefaultValues[i] = {};

        formData.forEach((data) => {
          if (data?.className?.includes("project-default-checked")) {
            newCheckedItemsTemp.push({
              roomOrder: i,
              name: data?.name?.replace("[]", ""),
            });

            newDefaultValues[i][data?.name] = [data?.values[0]?.value];
          }
        });
      }

      setCheckedItems([...checkedItems, ...newCheckedItemsTemp]);

      // Güncellenmiş form verilerini oluştur
      const updatedBlocks = [...blocks];
      if (blocks.length > 0) {
        // Oda sayısını arttır
        if (updatedRoomCount > blocks[0].roomCount) {
          for (let i = blocks[0].roomCount; i < updatedRoomCount; i++) {
            updatedBlocks[0].rooms.push({});
          }
        }
        // Oda sayısını azalt
        else if (updatedRoomCount < blocks[0].roomCount) {
          updatedBlocks[0].rooms = updatedBlocks[0].rooms.slice(
            0,
            updatedRoomCount
          );
        }
        updatedBlocks[0].roomCount = updatedRoomCount; // Oda sayısını güncelle
      }

      setBlocks(updatedBlocks);
    } else {
      toast.error("Lütfen geçerli bir konut sayısı giriniz");
    }
  };

  const blockDataSet = (blockIndex, keyx, value) => {
    var newDatas = blocks.map((block, key) => {
      if (blockIndex == key) {
        var newData2 = block.rooms.map((room, keyRoom) => {
          if (keyRoom == selectedRoom) {
            return {
              ...room,
              [keyx]: value,
            };
          } else {
            return room;
          }
        });

        return {
          ...block,
          rooms: [...newData2],
        };
      } else {
        return block;
      }
    });

    var newErrors = validationErrors.filter(
      (validationError) => validationError != keyx
    );

    setValidationErrors(newErrors);

    setBlocks(newDatas);
    setRendered(rendered + 1);
  };

  const blockCheckboxDataSet = (blockIndex, keyx, value, isChecked) => {
    var newDatas = blocks.map((block, key) => {
      if (blockIndex == key) {
        var newData2 = block.rooms.map((room, keyRoom) => {
          if (keyRoom == selectedRoom) {
            if (room[keyx]) {
              if (room[keyx].includes(value)) {
                var newKeyValues = room[keyx].filter((keyVal) => {
                  if (keyVal != value) {
                    return keyVal;
                  }
                });

                return {
                  ...room,
                  [keyx]: newKeyValues,
                };
              } else {
                return {
                  ...room,
                  [keyx]: [...room[keyx], value],
                };
              }
            } else {
              return {
                ...room,
                [keyx]: [value],
              };
            }
          } else {
            return room;
          }
        });

        return {
          ...block,
          rooms: [...newData2],
        };
      } else {
        return block;
      }
    });
    setBlocks(newDatas);
    setRendered(rendered + 1);
  };

  const changeFormImage = (blockIndex, keyx, event) => {
    const file = event.target.files[0];
    const reader = new FileReader();
    reader.onload = () => {
      var newDatas = blocks.map((block, key) => {
        if (blockIndex == key) {
          var newData2 = block.rooms.map((room, keyRoom) => {
            if (keyRoom == selectedRoom) {
              return {
                ...room,
                [keyx]: file,
                [keyx + "_imagex"]: reader.result,
              };
            } else {
              return room;
            }
          });

          return {
            ...block,
            rooms: [...newData2],
          };
        } else {
          return block;
        }
      });

      var newErrors = validationErrors.filter(
        (validationError) => validationError != keyx
      );
      setValidationErrors(newErrors);
      setBlocks(newDatas);
      setRendered(rendered + 1);
    };

    if (file) {
      reader.readAsDataURL(file);
    }
  };

  const setCheckedItemsFunc = (name, checked, order) => {
    if (checked) {
      setCheckedItems([
        ...checkedItems,
        {
          roomOrder: selectedRoom,
          name: name.replace("[]", ""),
        },
      ]);
    } else {
      var newItems = checkedItems.filter((checkedItem) => {
        if (
          checkedItem.roomOrder == selectedRoom &&
          checkedItem.name == name.replace("[]", "")
        ) {
        } else {
          return checkedItem;
        }
      });

      setCheckedItems(newItems);
    }
  };
  const [isFixed, setIsFixed] = useState(false);

  useEffect(() => {
    const handleScroll = () => {
      const navigatorElement = document.getElementById("roomNavigator");
      const offsetTop = navigatorElement.offsetTop;
      const scrollTop = window.scrollY;

      if (
        scrollTop > offsetTop &&
        scrollTop < document.documentElement.scrollHeight - window.innerHeight
      ) {
        setIsFixed(true);
      } else {
        setIsFixed(false);
      }
    };

    window.addEventListener("scroll", handleScroll);
    return () => {
      window.removeEventListener("scroll", handleScroll);
    };
  }, []);

  return (
    <>
      <div className="section-title mt-5">
        <h2>Projedeki İlan Sayısı</h2>
      </div>
      {!formGenerated && ( // Form oluşturulmamışsa butonu göster
        <div className="card p-3 mt-3">
          <div className="d-flex">
            <input
              type="number"
              min={0}
              style={{ width: "150px" }}
              className="form-control"
              value={roomCount === 0 ? "" : roomCount}
              onChange={(e) => setRoomCount(e.target.value)}
            />
            <span
              id="generate_tabs"
              style={{
                width: "130px",
                justifyContent: "center",
                alignItems: "center",
              }}
              onClick={setRoomCountFunc}
              className="mx-2 d-flex btn btn-primary has_blocks-close"
            >
              Formu Oluştur
            </span>
          </div>
        </div>
      )}

      {formGenerated && ( // Form oluşturulmuşsa güncelleme input'u ve butonu göster
        <div className="card p-3 mt-3">
          <div className="d-flex">
            <input
              type="number"
              min={0}
              style={{ width: "150px" }}
              className="form-control"
              value={updatedRoomCount === 0 ? "" : updatedRoomCount}
              onChange={(e) => setUpdatedRoomCount(e.target.value)}
            />
            <span
              id="update_tabs"
              style={{
                width: "130px",
                justifyContent: "center",
                alignItems: "center",
              }}
              onClick={updateRoomCount}
              className="mx-2 d-flex btn btn-warning has_blocks-close"
            >
              Güncelle
            </span>
          </div>
        </div>
      )}

      {blocks.length > 0 && (
        <>
          <div className="section-title mt-5">
            <h2>Projedeki İlanları</h2>
          </div>
          <div className="row">
            <div className="col-md-3">
              <div
                id="roomNavigator"
                className={`p-3 mt-3 card ${isFixed ? "fixed-room-navigator" : "original-room-navigator"
                  }`}
                style={{ position: "relative" }}
              >
                <RoomNavigator
                  slug={slug}
                  formDataHousing={formDataHousing}
                  haveBlock={false}
                  validationErrors={validationErrors}
                  setValidationErrors={setValidationErrors}
                  formData={formData}
                  selectedBlock={selectedBlock}
                  blocks={blocks}
                  setBlocks={setBlocks}
                  selectedRoom={selectedRoom}
                  setSelectedRoom={setSelectedRoom}
                />
              </div>
            </div>
            <div className="col-md-9">
              <div className="p-3 mt-3 card" style={{ position: "relative" }}>
                <div id="housing-forms">
                  {anotherBlockErrors.length > 0 ? (
                    <Alert icon={false} severity="error">
                      <ul style={{ margin: 0 }}>
                        {anotherBlockErrors.map((anotherBlockError) => {
                          return <li>{anotherBlockError}</li>;
                        })}
                      </ul>
                    </Alert>
                  ) : (
                    ""
                  )}

                  {blocks.length > 0 ? (
                    <div className="housing-form mt-7">
                      {formData.map((data, i) => {
                        if (
                          slug == "satilik" &&
                          !data?.className?.includes(
                            "only-show-project-rent"
                          ) &&
                          !data?.className?.includes(
                            "only-show-project-daliy-rent"
                          )
                        ) {
                          if (!data?.className?.includes("project-disabled")) {
                            var isX = null;
                            if (
                              data?.className?.includes("--if-show-checked-")
                            ) {
                              isX = !checkedItems.find((checkedItem) => {
                                return (
                                  checkedItem.roomOrder == 0 &&
                                  checkedItem.name ==
                                  data?.className?.split(
                                    "--if-show-checked-"
                                  )[1]
                                );
                              });
                            }
                            if (
                              !data?.className?.includes(
                                "only-not-show-project"
                              )
                            ) {
                              if (data.type == "text") {
                                return (
                                  <div
                                    className={
                                      "form-group " + (isX ? "d-none" : "")
                                    }
                                  >
                                    <label className="font-bold" htmlFor="">
                                      <div className="d-flex">
                                        {data.label}
                                        {data.description != undefined ? (
                                          <Tooltip
                                            className="mx-2"
                                            title={data.description}
                                            placement="top-start"
                                          >
                                            <div>
                                              <i className="fa fa-circle-info"></i>
                                            </div>
                                          </Tooltip>
                                        ) : (
                                          ""
                                        )}
                                        {data.required ? (
                                          <span className="required-span">
                                            *
                                          </span>
                                        ) : (
                                          ""
                                        )}
                                      </div>
                                    </label>
                                    {data?.className?.includes("price-only") ||
                                      data?.className?.includes("number-only") ? (
                                      <input
                                        id={data?.name.replace("[]", "")}
                                        type="text"
                                        value={
                                          blocks[selectedBlock]?.rooms[
                                            selectedRoom
                                          ] &&
                                            blocks[selectedBlock]?.rooms[
                                            selectedRoom
                                            ][data.name]
                                            ? blocks[selectedBlock]?.rooms[
                                            selectedRoom
                                            ][data.name]
                                            : ""
                                        }
                                        onChange={(e) => {
                                          blockDataSet(
                                            selectedBlock,
                                            data?.name,
                                            dotNumberFormat(e.target.value)
                                          );
                                        }}
                                        className={
                                          "form-control " +
                                          (validationErrors.includes(data?.name)
                                            ? "error-border"
                                            : "") +
                                          " " +
                                          (allErrors.includes(
                                            data?.name.replace("[]", "")
                                          )
                                            ? "error-border"
                                            : "")
                                        }
                                      />
                                    ) : data?.className?.includes(
                                      "tel-only"
                                    ) ? (
                                      <input
                                        id={data?.name.replace("[]", "")}
                                        type="text"
                                        value={
                                          blocks[selectedBlock]?.rooms[
                                            selectedRoom
                                          ] &&
                                            blocks[selectedBlock]?.rooms[
                                            selectedRoom
                                            ][data.name]
                                            ? blocks[selectedBlock]?.rooms[
                                            selectedRoom
                                            ][data.name]
                                            : ""
                                        }
                                        onChange={(e) => {
                                          blockDataSet(
                                            selectedBlock,
                                            data?.name,
                                            telNumberFormat(e.target.value)
                                          );
                                        }}
                                        className={
                                          "form-control " +
                                          (validationErrors.includes(data?.name)
                                            ? "error-border"
                                            : "") +
                                          " " +
                                          (allErrors.includes(
                                            data?.name.replace("[]", "")
                                          )
                                            ? "error-border"
                                            : "")
                                        }
                                      />
                                    ) : (
                                      <input
                                        id={data?.name.replace("[]", "")}
                                        type="text"
                                        value={
                                          blocks[selectedBlock]?.rooms[
                                            selectedRoom
                                          ] &&
                                            blocks[selectedBlock]?.rooms[
                                            selectedRoom
                                            ][data.name]
                                            ? blocks[selectedBlock]?.rooms[
                                            selectedRoom
                                            ][data.name]
                                            : ""
                                        }
                                        onChange={(e) => {
                                          blockDataSet(
                                            selectedBlock,
                                            data?.name,
                                            e.target.value
                                          );
                                        }}
                                        className={
                                          "form-control " +
                                          (validationErrors.includes(data?.name)
                                            ? "error-border"
                                            : "") +
                                          " " +
                                          (allErrors.includes(
                                            data?.name.replace("[]", "")
                                          )
                                            ? "error-border"
                                            : "")
                                        }
                                      />
                                    )}
                                  </div>
                                );
                              } else if (data.type == "date") {
                                return (
                                  <div
                                    className={
                                      "form-group " + (isX ? "d-none" : "")
                                    }
                                  >
                                    <label className="font-bold" htmlFor="">
                                      <div className="d-flex">
                                        {data.label}
                                        {data.description != undefined ? (
                                          <Tooltip
                                            className="mx-2"
                                            title={data.description}
                                            placement="top-start"
                                          >
                                            <div>
                                              <i className="fa fa-circle-info"></i>
                                            </div>
                                          </Tooltip>
                                        ) : (
                                          ""
                                        )}
                                        {data.required ? (
                                          <span className="required-span">
                                            *
                                          </span>
                                        ) : (
                                          ""
                                        )}
                                      </div>
                                    </label>
                                    <input
                                      id={data?.name.replace("[]", "")}
                                      type="date"
                                      value={
                                        blocks[selectedBlock]?.rooms[
                                          selectedRoom
                                        ] &&
                                          blocks[selectedBlock]?.rooms[
                                          selectedRoom
                                          ][data.name]
                                          ? blocks[selectedBlock]?.rooms[
                                          selectedRoom
                                          ][data.name]
                                          : ""
                                      }
                                      onChange={(e) => {
                                        if (e.target.value.length == 10) {
                                          blockDataSet(
                                            selectedBlock,
                                            data?.name,
                                            e.target.value
                                          );
                                        }
                                      }}
                                      className={
                                        "form-control " +
                                        (validationErrors.includes(data?.name)
                                          ? "error-border"
                                          : "") +
                                        " " +
                                        (allErrors.includes(
                                          data?.name.replace("[]", "")
                                        )
                                          ? "error-border"
                                          : "")
                                      }
                                    />
                                  </div>
                                );
                              } else if (data.type == "select") {
                                return (
                                  <div
                                    className={
                                      "form-group " + (isX ? "d-none" : "")
                                    }
                                  >
                                    <label className="font-bold" htmlFor="">
                                      <div className="d-flex">
                                        {data.label}
                                        {data.description != undefined ? (
                                          <Tooltip
                                            className="mx-2"
                                            title={data.description}
                                            placement="top-start"
                                          >
                                            <div>
                                              <i className="fa fa-circle-info"></i>
                                            </div>
                                          </Tooltip>
                                        ) : (
                                          ""
                                        )}
                                        {data.required ? (
                                          <span className="required-span">
                                            *
                                          </span>
                                        ) : (
                                          ""
                                        )}
                                      </div>
                                    </label>
                                    <select
                                      id={data?.name.replace("[]", "")}
                                      name=""
                                      className={
                                        "form-control " +
                                        (validationErrors.includes(data?.name)
                                          ? "error-border"
                                          : "") +
                                        " " +
                                        (allErrors.includes(
                                          data?.name.replace("[]", "")
                                        )
                                          ? "error-border"
                                          : "")
                                      }
                                      onChange={(e) => {
                                        blockDataSet(
                                          selectedBlock,
                                          data?.name,
                                          e.target.value
                                        );
                                      }}
                                      value={
                                        blocks[selectedBlock]?.rooms[
                                          selectedRoom
                                        ] &&
                                          blocks[selectedBlock]?.rooms[
                                          selectedRoom
                                          ][data.name]
                                          ? blocks[selectedBlock]?.rooms[
                                          selectedRoom
                                          ][data.name]
                                          : ""
                                      }
                                    >
                                      {data.values.map((valueSelect) => {
                                        return (
                                          <option value={valueSelect.value}>
                                            {valueSelect.label}
                                          </option>
                                        );
                                      })}
                                    </select>
                                  </div>
                                );
                              } else if (data.type == "checkbox-group") {
                                if (data.name == "payment-plan[]") {
                                  return (
                                    <div className={isX ? "d-none" : ""}>
                                      <div className="d-flex">
                                        {data.label}
                                        {data.description != undefined ? (
                                          <Tooltip
                                            className="mx-2"
                                            title={data.description}
                                            placement="top-start"
                                          >
                                            <div>
                                              <i className="fa fa-circle-info"></i>
                                            </div>
                                          </Tooltip>
                                        ) : (
                                          ""
                                        )}
                                        {data.required ? (
                                          <span className="required-span">
                                            *
                                          </span>
                                        ) : (
                                          ""
                                        )}
                                      </div>
                                      {data?.className?.includes(
                                        "project-not-change"
                                      ) ? (
                                        <div className="info-small-area">
                                          Bu alan projelerde seçilmesi zorunlu
                                          alandır değiştiremezsiniz
                                        </div>
                                      ) : (
                                        ""
                                      )}
                                      <div className="checkbox-groups">
                                        <div className="mb-3">
                                          <div className="row">
                                            {data.values.map((valueCheckbox) => {
                                              return (
                                                <div className="col-md-3">
                                                  <FormControlLabel
                                                    control={
                                                      <Checkbox
                                                        checked={
                                                          blocks[selectedBlock]
                                                            ?.rooms[
                                                            selectedRoom
                                                          ] &&
                                                            blocks[selectedBlock]
                                                              ?.rooms[selectedRoom][
                                                            data.name
                                                            ] &&
                                                            blocks[selectedBlock]
                                                              ?.rooms[selectedRoom]
                                                            ? blocks[
                                                              selectedBlock
                                                            ]?.rooms[
                                                              selectedRoom
                                                            ][
                                                              data.name
                                                            ].includes(
                                                              valueCheckbox.value
                                                            )
                                                            : false
                                                        }
                                                        onChange={(e) => {
                                                          if (
                                                            !data?.className?.includes(
                                                              "project-not-change"
                                                            )
                                                          ) {
                                                            blockCheckboxDataSet(
                                                              selectedBlock,
                                                              data?.name,
                                                              valueCheckbox?.value,
                                                              e
                                                            );
                                                            setCheckedItemsFunc(
                                                              data?.name,
                                                              e.target.checked
                                                            );
                                                          }
                                                        }}
                                                      />
                                                    }
                                                    label={valueCheckbox.label}
                                                  />
                                                </div>
                                              );
                                            })}
                                          </div>

                                          <label htmlFor="" className="font-bold">
                                            Ödeme Planı
                                          </label>
                                          <button
                                            className="btn btn-primary add-project-pay-dec-button d-block"
                                            onClick={() => {
                                              setPayDecOpen(true);
                                            }}
                                          >
                                            Ödeme Planını Yönet (
                                            {blocks[selectedBlock]?.rooms[
                                              selectedRoom
                                            ]
                                              ? blocks[selectedBlock]?.rooms[
                                                selectedRoom
                                              ]?.payDecs?.length
                                              : 0}
                                            )
                                          </button>
                                        </div>
                                      </div>
                                    </div>
                                  );
                                } else {
                                  return (
                                    <div className={isX ? "d-none" : ""}>
                                      <div className="d-flex">
                                        {data.label}
                                        {data.description != undefined ? (
                                          <Tooltip
                                            className="mx-2"
                                            title={data.description}
                                            placement="top-start"
                                          >
                                            <div>
                                              <i className="fa fa-circle-info"></i>
                                            </div>
                                          </Tooltip>
                                        ) : (
                                          ""
                                        )}
                                        {data.required ? (
                                          <span className="required-span">
                                            *
                                          </span>
                                        ) : (
                                          ""
                                        )}
                                      </div>
                                      {data?.className?.includes(
                                        "project-not-change"
                                      ) ? (
                                        <div className="info-small-area">
                                          Bu alan projelerde seçilmesi zorunlu
                                          alandır değiştiremezsiniz
                                        </div>
                                      ) : (
                                        ""
                                      )}
                                      <div className="checkbox-groups">
                                        <div className="row">
                                          {data.values.map((valueCheckbox) => {
                                            return (
                                              <div className="col-md-3">
                                                <FormControlLabel
                                                  control={
                                                    <Checkbox
                                                      checked={
                                                        blocks[selectedBlock]
                                                          ?.rooms[
                                                          selectedRoom
                                                        ] &&
                                                          blocks[selectedBlock]
                                                            ?.rooms[selectedRoom][
                                                          data.name
                                                          ] &&
                                                          blocks[selectedBlock]
                                                            ?.rooms[selectedRoom]
                                                          ? blocks[
                                                            selectedBlock
                                                          ]?.rooms[
                                                            selectedRoom
                                                          ][
                                                            data.name
                                                          ].includes(
                                                            valueCheckbox.value
                                                          )
                                                          : false
                                                      }
                                                      onChange={(e) => {
                                                        if (
                                                          !data?.className?.includes(
                                                            "project-not-change"
                                                          )
                                                        ) {
                                                          blockCheckboxDataSet(
                                                            selectedBlock,
                                                            data?.name,
                                                            valueCheckbox?.value,
                                                            e
                                                          );
                                                          setCheckedItemsFunc(
                                                            data?.name,
                                                            e.target.checked
                                                          );
                                                        }
                                                      }}
                                                    />
                                                  }
                                                  label={valueCheckbox.label}
                                                />
                                              </div>
                                            );
                                          })}
                                        </div>
                                      </div>
                                    </div>
                                  );
                                }
                              } else if (data.type == "file") {
                                return (
                                  <div
                                    className={
                                      "form-group " + (isX ? "d-none" : "")
                                    }
                                  >
                                    <label className="font-bold" htmlFor="">
                                      {data.label}{" "}
                                      {data.required ? (
                                        <span className="required-span">*</span>
                                      ) : (
                                        ""
                                      )}
                                    </label>
                                    <input
                                      id={data?.name.replace("[]", "")}
                                      accept="image/png, image/gif, image/jpeg"
                                      onChange={(event) => {
                                        changeFormImage(
                                          selectedBlock,
                                          data?.name,
                                          event
                                        );
                                      }}
                                      type="file"
                                      className={
                                        "form-control " +
                                        (validationErrors.includes(data?.name)
                                          ? "error-border"
                                          : "") +
                                        " " +
                                        (allErrors.includes(
                                          data?.name.replace("[]", "")
                                        )
                                          ? "error-border"
                                          : "")
                                      }
                                    />
                                    <div className="project_imaget">
                                      {
                                        blocks[selectedBlock]?.rooms[
                                          selectedRoom
                                        ] &&
                                          blocks[selectedBlock]?.rooms[
                                          selectedRoom
                                          ][data.name + "_imagex"] ? 
                                          <img
                                        src={
                                          blocks[selectedBlock]?.rooms[
                                            selectedRoom
                                          ] &&
                                            blocks[selectedBlock]?.rooms[
                                            selectedRoom
                                            ][data.name + "_imagex"]
                                            ? blocks[selectedBlock]?.rooms[
                                            selectedRoom
                                            ][data.name + "_imagex"]
                                            : ""
                                        }
                                        alt=""
                                      /> : ""
                                      }
                                      
                                    </div>
                                  </div>
                                );
                              }
                            }
                          }
                        } else if (
                          slug == "devren-satilik" &&
                          !data?.className?.includes(
                            "only-show-project-rent"
                          ) &&
                          !data?.className?.includes(
                            "only-show-project-daliy-rent"
                          )
                        ) {
                          if (!data?.className?.includes("project-disabled")) {
                            if (
                              !data?.className?.includes(
                                "only-not-show-project"
                              )
                            ) {
                              var isX = null;
                              if (
                                data?.className?.includes("--if-show-checked-")
                              ) {
                                isX = !checkedItems.find((checkedItem) => {
                                  return (
                                    checkedItem.roomOrder == 0 &&
                                    checkedItem.name ==
                                    data?.className?.split(
                                      "--if-show-checked-"
                                    )[1]
                                  );
                                });
                              }
                              if (data.type == "text") {
                                return (
                                  <div
                                    className={
                                      "form-group " + (isX ? "d-none" : "")
                                    }
                                  >
                                    <label className="font-bold" htmlFor="">
                                      <div className="d-flex">
                                        {data.label}
                                        {data.description != undefined ? (
                                          <Tooltip
                                            className="mx-2"
                                            title={data.description}
                                            placement="top-start"
                                          >
                                            <div>
                                              <i className="fa fa-circle-info"></i>
                                            </div>
                                          </Tooltip>
                                        ) : (
                                          ""
                                        )}
                                        {data.required ? (
                                          <span className="required-span">
                                            *
                                          </span>
                                        ) : (
                                          ""
                                        )}
                                      </div>
                                    </label>
                                    {data?.className?.includes("price-only") ||
                                      data?.className?.includes("number-only") ? (
                                      <input
                                        id={data?.name.replace("[]", "")}
                                        type="text"
                                        value={
                                          blocks[selectedBlock]?.rooms[
                                            selectedRoom
                                          ] &&
                                            blocks[selectedBlock]?.rooms[
                                            selectedRoom
                                            ][data.name]
                                            ? blocks[selectedBlock]?.rooms[
                                            selectedRoom
                                            ][data.name]
                                            : ""
                                        }
                                        onChange={(e) => {
                                          blockDataSet(
                                            selectedBlock,
                                            data?.name,
                                            dotNumberFormat(e.target.value)
                                          );
                                        }}
                                        className={
                                          "form-control " +
                                          (validationErrors.includes(data?.name)
                                            ? "error-border"
                                            : "") +
                                          " " +
                                          (allErrors.includes(
                                            data?.name.replace("[]", "")
                                          )
                                            ? "error-border"
                                            : "")
                                        }
                                      />
                                    ) : data?.className?.includes(
                                      "tel-only"
                                    ) ? (
                                      <input
                                        id={data?.name.replace("[]", "")}
                                        type="text"
                                        value={
                                          blocks[selectedBlock]?.rooms[
                                            selectedRoom
                                          ] &&
                                            blocks[selectedBlock]?.rooms[
                                            selectedRoom
                                            ][data.name]
                                            ? blocks[selectedBlock]?.rooms[
                                            selectedRoom
                                            ][data.name]
                                            : ""
                                        }
                                        onChange={(e) => {
                                          blockDataSet(
                                            selectedBlock,
                                            data?.name,
                                            telNumberFormat(e.target.value)
                                          );
                                        }}
                                        className={
                                          "form-control " +
                                          (validationErrors.includes(data?.name)
                                            ? "error-border"
                                            : "") +
                                          " " +
                                          (allErrors.includes(
                                            data?.name.replace("[]", "")
                                          )
                                            ? "error-border"
                                            : "")
                                        }
                                      />
                                    ) : (
                                      <input
                                        id={data?.name.replace("[]", "")}
                                        type="text"
                                        value={
                                          blocks[selectedBlock]?.rooms[
                                            selectedRoom
                                          ] &&
                                            blocks[selectedBlock]?.rooms[
                                            selectedRoom
                                            ][data.name]
                                            ? blocks[selectedBlock]?.rooms[
                                            selectedRoom
                                            ][data.name]
                                            : ""
                                        }
                                        onChange={(e) => {
                                          blockDataSet(
                                            selectedBlock,
                                            data?.name,
                                            e.target.value
                                          );
                                        }}
                                        className={
                                          "form-control " +
                                          (validationErrors.includes(data?.name)
                                            ? "error-border"
                                            : "") +
                                          " " +
                                          (allErrors.includes(
                                            data?.name.replace("[]", "")
                                          )
                                            ? "error-border"
                                            : "")
                                        }
                                      />
                                    )}
                                  </div>
                                );
                              } else if (data.type == "date") {
                                return (
                                  <div
                                    className={
                                      "form-group " + (isX ? "d-none" : "")
                                    }
                                  >
                                    <label className="font-bold" htmlFor="">
                                      <div className="d-flex">
                                        {data.label}
                                        {data.description != undefined ? (
                                          <Tooltip
                                            className="mx-2"
                                            title={data.description}
                                            placement="top-start"
                                          >
                                            <div>
                                              <i className="fa fa-circle-info"></i>
                                            </div>
                                          </Tooltip>
                                        ) : (
                                          ""
                                        )}
                                        {data.required ? (
                                          <span className="required-span">
                                            *
                                          </span>
                                        ) : (
                                          ""
                                        )}
                                      </div>
                                    </label>
                                    <input
                                      id={data?.name.replace("[]", "")}
                                      type="date"
                                      value={
                                        blocks[selectedBlock]?.rooms[
                                          selectedRoom
                                        ] &&
                                          blocks[selectedBlock]?.rooms[
                                          selectedRoom
                                          ][data.name]
                                          ? blocks[selectedBlock]?.rooms[
                                          selectedRoom
                                          ][data.name]
                                          : ""
                                      }
                                      onChange={(e) => {
                                        if (e.target.value.length == 10) {
                                          blockDataSet(
                                            selectedBlock,
                                            data?.name,
                                            e.target.value
                                          );
                                        }
                                      }}
                                      className={
                                        "form-control " +
                                        (validationErrors.includes(data?.name)
                                          ? "error-border"
                                          : "") +
                                        " " +
                                        (allErrors.includes(
                                          data?.name.replace("[]", "")
                                        )
                                          ? "error-border"
                                          : "")
                                      }
                                    />
                                  </div>
                                );
                              } else if (data.type == "select") {
                                return (
                                  <div
                                    className={
                                      "form-group " + (isX ? "d-none" : "")
                                    }
                                  >
                                    <label className="font-bold" htmlFor="">
                                      <div className="d-flex">
                                        {data.label}
                                        {data.description != undefined ? (
                                          <Tooltip
                                            className="mx-2"
                                            title={data.description}
                                            placement="top-start"
                                          >
                                            <div>
                                              <i className="fa fa-circle-info"></i>
                                            </div>
                                          </Tooltip>
                                        ) : (
                                          ""
                                        )}
                                        {data.required ? (
                                          <span className="required-span">
                                            *
                                          </span>
                                        ) : (
                                          ""
                                        )}
                                      </div>
                                    </label>
                                    <select
                                      id={data?.name.replace("[]", "")}
                                      name=""
                                      className={
                                        "form-control " +
                                        (validationErrors.includes(data?.name)
                                          ? "error-border"
                                          : "") +
                                        " " +
                                        (allErrors.includes(
                                          data?.name.replace("[]", "")
                                        )
                                          ? "error-border"
                                          : "")
                                      }
                                      onChange={(e) => {
                                        blockDataSet(
                                          selectedBlock,
                                          data?.name,
                                          e.target.value
                                        );
                                      }}
                                      value={
                                        blocks[selectedBlock]?.rooms[
                                          selectedRoom
                                        ] &&
                                          blocks[selectedBlock]?.rooms[
                                          selectedRoom
                                          ][data.name]
                                          ? blocks[selectedBlock]?.rooms[
                                          selectedRoom
                                          ][data.name]
                                          : ""
                                      }
                                    >
                                      {data.values.map((valueSelect) => {
                                        return (
                                          <option value={valueSelect.value}>
                                            {valueSelect.label}
                                          </option>
                                        );
                                      })}
                                    </select>
                                  </div>
                                );
                              } else if (data.type == "checkbox-group") {
                                if (data.name == "payment-plan[]") {
                                  console.log("asd");
                                  return (
                                    <div>
                                      <div>
                                        <label
                                          className="mt-3 font-bold"
                                          htmlFor=""
                                        >
                                          <div className="d-flex">
                                            {data.label}
                                            {data.description != undefined ? (
                                              <Tooltip
                                                className="mx-2"
                                                title={data.description}
                                                placement="top-start"
                                              >
                                                <div>
                                                  <i className="fa fa-circle-info"></i>
                                                </div>
                                              </Tooltip>
                                            ) : (
                                              ""
                                            )}
                                            {data.required ? (
                                              <span className="required-span">
                                                *
                                              </span>
                                            ) : (
                                              ""
                                            )}
                                          </div>
                                        </label>
                                        <div
                                          className="checkbox-groups"
                                          id={data?.name.replace("[]", "")}
                                        >
                                          <div className="">
                                            {data.values.map(
                                              (valueCheckbox) => {
                                                return (
                                                  <div className="col-md-3">
                                                    <FormControlLabel
                                                      control={
                                                        <Switch
                                                          label={
                                                            valueCheckbox.label
                                                          }
                                                          checked={
                                                            blocks[
                                                              selectedBlock
                                                            ]?.rooms[
                                                              selectedRoom
                                                            ] &&
                                                              blocks[
                                                                selectedBlock
                                                              ]?.rooms[
                                                              selectedRoom
                                                              ][data.name] &&
                                                              blocks[
                                                                selectedBlock
                                                              ]?.rooms[
                                                              selectedRoom
                                                              ][data.name] &&
                                                              blocks[
                                                                selectedBlock
                                                              ]?.rooms[
                                                              selectedRoom
                                                              ]
                                                              ? blocks[
                                                                selectedBlock
                                                              ]?.rooms[
                                                                selectedRoom
                                                              ][
                                                                data.name
                                                              ].includes(
                                                                valueCheckbox.value
                                                              )
                                                              : false
                                                          }
                                                          onChange={(e) => {
                                                            blockCheckboxDataSet(
                                                              selectedBlock,
                                                              data?.name,
                                                              valueCheckbox?.value,
                                                              e
                                                            );
                                                          }}
                                                        />
                                                      }
                                                      label={
                                                        valueCheckbox.label
                                                      }
                                                    />
                                                  </div>
                                                );
                                              }
                                            )}
                                          </div>
                                        </div>
                                      </div>
                                      <div
                                        className={
                                          "pay-decs mb-3 mt-3 " +
                                          (!(
                                            blocks[selectedBlock] &&
                                            blocks[selectedBlock].rooms[
                                            selectedRoom
                                            ] &&
                                            blocks[selectedBlock].rooms[
                                            selectedRoom
                                            ]["payment-plan[]"] &&
                                            blocks[selectedBlock].rooms[
                                              selectedRoom
                                            ]["payment-plan[]"].includes(
                                              "taksitli"
                                            )
                                          )
                                            ? "d-none"
                                            : "")
                                        }
                                      >
                                        <label htmlFor="" className="font-bold">
                                          Ödeme Planı
                                        </label>
                                        <button
                                          className="btn btn-primary d-block"
                                          onClick={() => {
                                            setPayDecOpen(true);
                                          }}
                                        >
                                          Ödeme Planını Yönet (
                                          {blocks[selectedBlock]?.rooms[
                                            selectedRoom
                                          ]
                                            ? blocks[selectedBlock]?.rooms[
                                              selectedRoom
                                            ]?.payDecs?.length
                                            : 0}
                                          )
                                        </button>
                                      </div>
                                    </div>
                                  );
                                } else {
                                  return (
                                    <div className={isX ? "d-none" : ""}>
                                      <div className="d-flex">
                                        {data.label}
                                        {data.description != undefined ? (
                                          <Tooltip
                                            className="mx-2"
                                            title={data.description}
                                            placement="top-start"
                                          >
                                            <div>
                                              <i className="fa fa-circle-info"></i>
                                            </div>
                                          </Tooltip>
                                        ) : (
                                          ""
                                        )}
                                        {data.required ? (
                                          <span className="required-span">
                                            *
                                          </span>
                                        ) : (
                                          ""
                                        )}
                                      </div>
                                      {data?.className?.includes(
                                        "project-not-change"
                                      ) ? (
                                        <div className="info-small-area">
                                          Bu alan projelerde seçilmesi zorunlu
                                          alandır değiştiremezsiniz
                                        </div>
                                      ) : (
                                        ""
                                      )}
                                      <div className="checkbox-groups">
                                        <div className="row">
                                          {data.values.map((valueCheckbox) => {
                                            return (
                                              <div className="col-md-3">
                                                <FormControlLabel
                                                  control={
                                                    <Checkbox
                                                      checked={
                                                        blocks[selectedBlock]
                                                          ?.rooms[
                                                          selectedRoom
                                                        ] &&
                                                          blocks[selectedBlock]
                                                            ?.rooms[selectedRoom][
                                                          data.name
                                                          ] &&
                                                          blocks[selectedBlock]
                                                            ?.rooms[selectedRoom]
                                                          ? blocks[
                                                            selectedBlock
                                                          ]?.rooms[
                                                            selectedRoom
                                                          ][
                                                            data.name
                                                          ].includes(
                                                            valueCheckbox.value
                                                          )
                                                          : false
                                                      }
                                                      onChange={(e) => {
                                                        if (
                                                          !data?.className?.includes(
                                                            "project-not-change"
                                                          )
                                                        ) {
                                                          blockCheckboxDataSet(
                                                            selectedBlock,
                                                            data?.name,
                                                            valueCheckbox?.value,
                                                            e
                                                          );
                                                          setCheckedItemsFunc(
                                                            data?.name,
                                                            e.target.checked
                                                          );
                                                        }
                                                      }}
                                                    />
                                                  }
                                                  label={valueCheckbox.label}
                                                />
                                              </div>
                                            );
                                          })}
                                        </div>
                                      </div>
                                    </div>
                                  );
                                }
                              } else if (data.type == "file") {
                                return (
                                  <div
                                    className={
                                      "form-group " + (isX ? "d-none" : "")
                                    }
                                  >
                                    <label className="font-bold" htmlFor="">
                                      {data.label}{" "}
                                      {data.required ? (
                                        <span className="required-span">*</span>
                                      ) : (
                                        ""
                                      )}
                                    </label>
                                    <input
                                      id={data?.name.replace("[]", "")}
                                      accept="image/png, image/gif, image/jpeg"
                                      onChange={(event) => {
                                        changeFormImage(
                                          selectedBlock,
                                          data?.name,
                                          event
                                        );
                                      }}
                                      type="file"
                                      className={
                                        "form-control " +
                                        (validationErrors.includes(data?.name)
                                          ? "error-border"
                                          : "") +
                                        " " +
                                        (allErrors.includes(
                                          data?.name.replace("[]", "")
                                        )
                                          ? "error-border"
                                          : "")
                                      }
                                    />
                                    <div className="project_imaget">
                                      <img
                                        src={
                                          blocks[selectedBlock]?.rooms[
                                            selectedRoom
                                          ] &&
                                            blocks[selectedBlock]?.rooms[
                                            selectedRoom
                                            ][data.name + "_imagex"]
                                            ? blocks[selectedBlock]?.rooms[
                                            selectedRoom
                                            ][data.name + "_imagex"]
                                            : ""
                                        }
                                        alt=""
                                      />
                                    </div>
                                  </div>
                                );
                              }
                            }
                          }
                        } else if (
                          slug == "kiralik" &&
                          !data?.className?.includes(
                            "only-show-project-sale"
                          ) &&
                          !data?.className?.includes(
                            "only-show-project-daliy-rent"
                          )
                        ) {
                          if (!data?.className?.includes("project-disabled")) {
                            if (
                              !data?.className?.includes(
                                "only-not-show-project"
                              )
                            ) {
                              var isX = null;
                              if (
                                data?.className?.includes("--if-show-checked-")
                              ) {
                                isX = !checkedItems.find((checkedItem) => {
                                  return (
                                    checkedItem.roomOrder == 0 &&
                                    checkedItem.name ==
                                    data?.className?.split(
                                      "--if-show-checked-"
                                    )[1]
                                  );
                                });
                              }
                              if (data.type == "text") {
                                return (
                                  <div
                                    className={
                                      "form-group " + (isX ? "d-none" : "")
                                    }
                                  >
                                    <label className="font-bold" htmlFor="">
                                      <div className="d-flex">
                                        {data.label}
                                        {data.description != undefined ? (
                                          <Tooltip
                                            className="mx-2"
                                            title={data.description}
                                            placement="top-start"
                                          >
                                            <div>
                                              <i className="fa fa-circle-info"></i>
                                            </div>
                                          </Tooltip>
                                        ) : (
                                          ""
                                        )}
                                        {data.required ? (
                                          <span className="required-span">
                                            *
                                          </span>
                                        ) : (
                                          ""
                                        )}
                                      </div>
                                    </label>
                                    {data?.className?.includes("price-only") ||
                                      data?.className?.includes("number-only") ? (
                                      <input
                                        id={data?.name.replace("[]", "")}
                                        type="text"
                                        value={
                                          blocks[selectedBlock]?.rooms[
                                            selectedRoom
                                          ] &&
                                            blocks[selectedBlock]?.rooms[
                                            selectedRoom
                                            ][data.name]
                                            ? blocks[selectedBlock]?.rooms[
                                            selectedRoom
                                            ][data.name]
                                            : ""
                                        }
                                        onChange={(e) => {
                                          blockDataSet(
                                            selectedBlock,
                                            data?.name,
                                            dotNumberFormat(e.target.value)
                                          );
                                        }}
                                        className={
                                          "form-control " +
                                          (validationErrors.includes(data?.name)
                                            ? "error-border"
                                            : "") +
                                          " " +
                                          (allErrors.includes(
                                            data?.name.replace("[]", "")
                                          )
                                            ? "error-border"
                                            : "")
                                        }
                                      />
                                    ) : data?.className?.includes(
                                      "tel-only"
                                    ) ? (
                                      <input
                                        id={data?.name.replace("[]", "")}
                                        type="text"
                                        value={
                                          blocks[selectedBlock]?.rooms[
                                            selectedRoom
                                          ] &&
                                            blocks[selectedBlock]?.rooms[
                                            selectedRoom
                                            ][data.name]
                                            ? blocks[selectedBlock]?.rooms[
                                            selectedRoom
                                            ][data.name]
                                            : ""
                                        }
                                        onChange={(e) => {
                                          blockDataSet(
                                            selectedBlock,
                                            data?.name,
                                            dotNumberFormat(e.target.value)
                                          );
                                        }}
                                        className={
                                          "form-control " +
                                          (validationErrors.includes(data?.name)
                                            ? "error-border"
                                            : "") +
                                          " " +
                                          (allErrors.includes(
                                            data?.name.replace("[]", "")
                                          )
                                            ? "error-border"
                                            : "")
                                        }
                                      />
                                    ) : (
                                      <input
                                        id={data?.name.replace("[]", "")}
                                        type="text"
                                        value={
                                          blocks[selectedBlock]?.rooms[
                                            selectedRoom
                                          ] &&
                                            blocks[selectedBlock]?.rooms[
                                            selectedRoom
                                            ][data.name]
                                            ? blocks[selectedBlock]?.rooms[
                                            selectedRoom
                                            ][data.name]
                                            : ""
                                        }
                                        onChange={(e) => {
                                          blockDataSet(
                                            selectedBlock,
                                            data?.name,
                                            e.target.value
                                          );
                                        }}
                                        className={
                                          "form-control " +
                                          (validationErrors.includes(data?.name)
                                            ? "error-border"
                                            : "") +
                                          " " +
                                          (allErrors.includes(
                                            data?.name.replace("[]", "")
                                          )
                                            ? "error-border"
                                            : "")
                                        }
                                      />
                                    )}
                                  </div>
                                );
                              } else if (data.type == "date") {
                                return (
                                  <div
                                    className={
                                      "form-group " + (isX ? "d-none" : "")
                                    }
                                  >
                                    <label className="font-bold" htmlFor="">
                                      <div className="d-flex">
                                        {data.label}
                                        {data.description != undefined ? (
                                          <Tooltip
                                            className="mx-2"
                                            title={data.description}
                                            placement="top-start"
                                          >
                                            <div>
                                              <i className="fa fa-circle-info"></i>
                                            </div>
                                          </Tooltip>
                                        ) : (
                                          ""
                                        )}
                                        {data.required ? (
                                          <span className="required-span">
                                            *
                                          </span>
                                        ) : (
                                          ""
                                        )}
                                      </div>
                                    </label>
                                    <input
                                      id={data?.name.replace("[]", "")}
                                      type="date"
                                      value={
                                        blocks[selectedBlock]?.rooms[
                                          selectedRoom
                                        ] &&
                                          blocks[selectedBlock]?.rooms[
                                          selectedRoom
                                          ][data.name]
                                          ? blocks[selectedBlock]?.rooms[
                                          selectedRoom
                                          ][data.name]
                                          : ""
                                      }
                                      onChange={(e) => {
                                        if (e.target.value.length == 10) {
                                          blockDataSet(
                                            selectedBlock,
                                            data?.name,
                                            e.target.value
                                          );
                                        }
                                      }}
                                      className={
                                        "form-control " +
                                        (validationErrors.includes(data?.name)
                                          ? "error-border"
                                          : "") +
                                        " " +
                                        (allErrors.includes(
                                          data?.name.replace("[]", "")
                                        )
                                          ? "error-border"
                                          : "")
                                      }
                                    />
                                  </div>
                                );
                              } else if (data.type == "select") {
                                return (
                                  <div
                                    className={
                                      "form-group " + (isX ? "d-none" : "")
                                    }
                                  >
                                    <label className="font-bold" htmlFor="">
                                      <div className="d-flex">
                                        {data.label}
                                        {data.description != undefined ? (
                                          <Tooltip
                                            className="mx-2"
                                            title={data.description}
                                            placement="top-start"
                                          >
                                            <div>
                                              <i className="fa fa-circle-info"></i>
                                            </div>
                                          </Tooltip>
                                        ) : (
                                          ""
                                        )}
                                        {data.required ? (
                                          <span className="required-span">
                                            *
                                          </span>
                                        ) : (
                                          ""
                                        )}
                                      </div>
                                    </label>
                                    <select
                                      id={data?.name.replace("[]", "")}
                                      name=""
                                      className={
                                        "form-control " +
                                        (validationErrors.includes(data?.name)
                                          ? "error-border"
                                          : "") +
                                        " " +
                                        (allErrors.includes(
                                          data?.name.replace("[]", "")
                                        )
                                          ? "error-border"
                                          : "")
                                      }
                                      onChange={(e) => {
                                        blockDataSet(
                                          selectedBlock,
                                          data?.name,
                                          e.target.value
                                        );
                                      }}
                                      value={
                                        blocks[selectedBlock]?.rooms[
                                          selectedRoom
                                        ] &&
                                          blocks[selectedBlock]?.rooms[
                                          selectedRoom
                                          ][data.name]
                                          ? blocks[selectedBlock]?.rooms[
                                          selectedRoom
                                          ][data.name]
                                          : ""
                                      }
                                    >
                                      {data.values.map((valueSelect) => {
                                        return (
                                          <option value={valueSelect.value}>
                                            {valueSelect.label}
                                          </option>
                                        );
                                      })}
                                    </select>
                                  </div>
                                );
                              } else if (data.type == "checkbox-group") {
                                if (data.name == "payment-plan[]") {
                                  return (
                                    <div>
                                      <div>
                                        <label
                                          className="mt-3 font-bold"
                                          htmlFor=""
                                        >
                                          <div className="d-flex">
                                            {data.label}
                                            {data.description != undefined ? (
                                              <Tooltip
                                                className="mx-2"
                                                title={data.description}
                                                placement="top-start"
                                              >
                                                <div>
                                                  <i className="fa fa-circle-info"></i>
                                                </div>
                                              </Tooltip>
                                            ) : (
                                              ""
                                            )}
                                            {data.required ? (
                                              <span className="required-span">
                                                *
                                              </span>
                                            ) : (
                                              ""
                                            )}
                                          </div>
                                        </label>
                                        <div
                                          className="checkbox-groups"
                                          id={data?.name.replace("[]", "")}
                                        >
                                          <div className="row">
                                            {data.values.map(
                                              (valueCheckbox) => {
                                                return (
                                                  <div className="col-md-3">
                                                    <FormControlLabel
                                                      control={
                                                        <Switch
                                                          label={
                                                            valueCheckbox.label
                                                          }
                                                          checked={
                                                            blocks[
                                                              selectedBlock
                                                            ]?.rooms[
                                                              selectedRoom
                                                            ] &&
                                                              blocks[
                                                                selectedBlock
                                                              ]?.rooms[
                                                              selectedRoom
                                                              ][data.name] &&
                                                              blocks[
                                                                selectedBlock
                                                              ]?.rooms[
                                                              selectedRoom
                                                              ][data.name] &&
                                                              blocks[
                                                                selectedBlock
                                                              ]?.rooms[
                                                              selectedRoom
                                                              ]
                                                              ? blocks[
                                                                selectedBlock
                                                              ]?.rooms[
                                                                selectedRoom
                                                              ][
                                                                data.name
                                                              ].includes(
                                                                valueCheckbox.value
                                                              )
                                                              : false
                                                          }
                                                          onChange={(e) => {
                                                            blockCheckboxDataSet(
                                                              selectedBlock,
                                                              data?.name,
                                                              valueCheckbox?.value,
                                                              e
                                                            );
                                                          }}
                                                        />
                                                      }
                                                      label={
                                                        valueCheckbox.label
                                                      }
                                                    />
                                                  </div>
                                                );
                                              }
                                            )}
                                            {allErrors.includes(
                                              data?.name.replace("[]", "")
                                            ) ? (
                                              <Alert severity="error">
                                                Harita üzerine bir konum seçin
                                              </Alert>
                                            ) : (
                                              ""
                                            )}
                                          </div>
                                        </div>
                                      </div>
                                      <div
                                        className={
                                          "pay-decs mb-3 mt-3 " +
                                          (!(
                                            blocks[selectedBlock] &&
                                            blocks[selectedBlock].rooms[
                                            selectedRoom
                                            ] &&
                                            blocks[selectedBlock].rooms[
                                            selectedRoom
                                            ]["payment-plan[]"] &&
                                            blocks[selectedBlock].rooms[
                                              selectedRoom
                                            ]["payment-plan[]"].includes(
                                              "taksitli"
                                            )
                                          )
                                            ? "d-none"
                                            : "")
                                        }
                                      >
                                        <label htmlFor="" className="font-bold">
                                          Ödeme Planı
                                        </label>
                                        <button
                                          className="btn btn-primary d-block"
                                          onClick={() => {
                                            setPayDecOpen(true);
                                          }}
                                        >
                                          Ödeme Planını Yönet (
                                          {blocks[selectedBlock]?.rooms[
                                            selectedRoom
                                          ]
                                            ? blocks[selectedBlock]?.rooms[
                                              selectedRoom
                                            ]?.payDecs?.length
                                            : 0}
                                          )
                                        </button>
                                      </div>
                                    </div>
                                  );
                                } else {
                                  return (
                                    <div>
                                      <div className="d-flex">
                                        {data.label}
                                        {data.description != undefined ? (
                                          <Tooltip
                                            className="mx-2"
                                            title={data.description}
                                            placement="top-start"
                                          >
                                            <div>
                                              <i className="fa fa-circle-info"></i>
                                            </div>
                                          </Tooltip>
                                        ) : (
                                          ""
                                        )}
                                        {data.required ? (
                                          <span className="required-span">
                                            *
                                          </span>
                                        ) : (
                                          ""
                                        )}
                                      </div>
                                      {data?.className?.includes(
                                        "project-not-change"
                                      ) ? (
                                        <div className="info-small-area">
                                          Bu alan projelerde seçilmesi zorunlu
                                          alandır değiştiremezsiniz
                                        </div>
                                      ) : (
                                        ""
                                      )}
                                      <div className="checkbox-groups">
                                        <div className="row">
                                          {data.values.map((valueCheckbox) => {
                                            return (
                                              <div className="col-md-3">
                                                <FormControlLabel
                                                  control={
                                                    <Checkbox
                                                      checked={
                                                        blocks[selectedBlock]
                                                          ?.rooms[
                                                          selectedRoom
                                                        ] &&
                                                          blocks[selectedBlock]
                                                            ?.rooms[selectedRoom][
                                                          data.name
                                                          ] &&
                                                          blocks[selectedBlock]
                                                            ?.rooms[selectedRoom]
                                                          ? blocks[
                                                            selectedBlock
                                                          ]?.rooms[
                                                            selectedRoom
                                                          ][
                                                            data.name
                                                          ].includes(
                                                            valueCheckbox.value
                                                          )
                                                          : false
                                                      }
                                                      onChange={(e) => {
                                                        if (
                                                          !data?.className?.includes(
                                                            "project-not-change"
                                                          )
                                                        ) {
                                                          blockCheckboxDataSet(
                                                            selectedBlock,
                                                            data?.name,
                                                            valueCheckbox?.value,
                                                            e
                                                          );
                                                          setCheckedItemsFunc(
                                                            data?.name,
                                                            e.target.checked
                                                          );
                                                        }
                                                      }}
                                                    />
                                                  }
                                                  label={valueCheckbox.label}
                                                />
                                              </div>
                                            );
                                          })}
                                        </div>
                                      </div>
                                    </div>
                                  );
                                }
                              } else if (data.type == "file") {
                                return (
                                  <div
                                    className={
                                      "form-group " + (isX ? "d-none" : "")
                                    }
                                  >
                                    <label className="font-bold" htmlFor="">
                                      {data.label}{" "}
                                      {data.required ? (
                                        <span className="required-span">*</span>
                                      ) : (
                                        ""
                                      )}
                                    </label>
                                    <input
                                      id={data?.name.replace("[]", "")}
                                      accept="image/png, image/gif, image/jpeg"
                                      onChange={(event) => {
                                        changeFormImage(
                                          selectedBlock,
                                          data?.name,
                                          event
                                        );
                                      }}
                                      type="file"
                                      className={
                                        "form-control " +
                                        (validationErrors.includes(data?.name)
                                          ? "error-border"
                                          : "") +
                                        " " +
                                        (allErrors.includes(
                                          data?.name.replace("[]", "")
                                        )
                                          ? "error-border"
                                          : "")
                                      }
                                    />
                                    <div className="project_imaget">
                                      <img
                                        src={
                                          blocks[selectedBlock]?.rooms[
                                            selectedRoom
                                          ] &&
                                            blocks[selectedBlock]?.rooms[
                                            selectedRoom
                                            ][data.name + "_imagex"]
                                            ? blocks[selectedBlock]?.rooms[
                                            selectedRoom
                                            ][data.name + "_imagex"]
                                            : ""
                                        }
                                        alt=""
                                      />
                                    </div>
                                  </div>
                                );
                              }
                            }
                          }
                        } else if (
                          slug == "devren-kiralik" &&
                          !data?.className?.includes(
                            "only-show-project-sale"
                          ) &&
                          !data?.className?.includes(
                            "only-show-project-daliy-rent"
                          )
                        ) {
                          if (!data?.className?.includes("project-disabled")) {
                            if (
                              !data?.className?.includes(
                                "only-not-show-project"
                              )
                            ) {
                              var isX = null;
                              if (
                                data?.className?.includes("--if-show-checked-")
                              ) {
                                isX = !checkedItems.find((checkedItem) => {
                                  return (
                                    checkedItem.roomOrder == 0 &&
                                    checkedItem.name ==
                                    data?.className?.split(
                                      "--if-show-checked-"
                                    )[1]
                                  );
                                });
                              }
                              if (isX) {
                              }
                              if (data.type == "text") {
                                return (
                                  <div
                                    className={
                                      "form-group " + (isX ? "d-none" : "")
                                    }
                                  >
                                    <label className="font-bold" htmlFor="">
                                      <div className="d-flex">
                                        {data.label}
                                        {data.description != undefined ? (
                                          <Tooltip
                                            className="mx-2"
                                            title={data.description}
                                            placement="top-start"
                                          >
                                            <div>
                                              <i className="fa fa-circle-info"></i>
                                            </div>
                                          </Tooltip>
                                        ) : (
                                          ""
                                        )}
                                        {data.required ? (
                                          <span className="required-span">
                                            *
                                          </span>
                                        ) : (
                                          ""
                                        )}
                                      </div>
                                    </label>
                                    {data?.className?.includes("price-only") ||
                                      data?.className?.includes("number-only") ? (
                                      <input
                                        id={data?.name.replace("[]", "")}
                                        type="text"
                                        value={
                                          blocks[selectedBlock]?.rooms[
                                            selectedRoom
                                          ] &&
                                            blocks[selectedBlock]?.rooms[
                                            selectedRoom
                                            ][data.name]
                                            ? blocks[selectedBlock]?.rooms[
                                            selectedRoom
                                            ][data.name]
                                            : ""
                                        }
                                        onChange={(e) => {
                                          blockDataSet(
                                            selectedBlock,
                                            data?.name,
                                            dotNumberFormat(e.target.value)
                                          );
                                        }}
                                        className={
                                          "form-control " +
                                          (validationErrors.includes(data?.name)
                                            ? "error-border"
                                            : "") +
                                          " " +
                                          (allErrors.includes(
                                            data?.name.replace("[]", "")
                                          )
                                            ? "error-border"
                                            : "")
                                        }
                                      />
                                    ) : data?.className?.includes(
                                      "tel-only"
                                    ) ? (
                                      <input
                                        id={data?.name.replace("[]", "")}
                                        type="text"
                                        value={
                                          blocks[selectedBlock]?.rooms[
                                            selectedRoom
                                          ] &&
                                            blocks[selectedBlock]?.rooms[
                                            selectedRoom
                                            ][data.name]
                                            ? blocks[selectedBlock]?.rooms[
                                            selectedRoom
                                            ][data.name]
                                            : ""
                                        }
                                        onChange={(e) => {
                                          blockDataSet(
                                            selectedBlock,
                                            data?.name,
                                            telNumberFormat(e.target.value)
                                          );
                                        }}
                                        className={
                                          "form-control " +
                                          (validationErrors.includes(data?.name)
                                            ? "error-border"
                                            : "") +
                                          " " +
                                          (allErrors.includes(
                                            data?.name.replace("[]", "")
                                          )
                                            ? "error-border"
                                            : "")
                                        }
                                      />
                                    ) : (
                                      <input
                                        id={data?.name.replace("[]", "")}
                                        type="text"
                                        value={
                                          blocks[selectedBlock]?.rooms[
                                            selectedRoom
                                          ] &&
                                            blocks[selectedBlock]?.rooms[
                                            selectedRoom
                                            ][data.name]
                                            ? blocks[selectedBlock]?.rooms[
                                            selectedRoom
                                            ][data.name]
                                            : ""
                                        }
                                        onChange={(e) => {
                                          blockDataSet(
                                            selectedBlock,
                                            data?.name,
                                            e.target.value
                                          );
                                        }}
                                        className={
                                          "form-control " +
                                          (validationErrors.includes(data?.name)
                                            ? "error-border"
                                            : "") +
                                          " " +
                                          (allErrors.includes(
                                            data?.name.replace("[]", "")
                                          )
                                            ? "error-border"
                                            : "")
                                        }
                                      />
                                    )}
                                  </div>
                                );
                              } else if (data.type == "date") {
                                return (
                                  <div
                                    className={
                                      "form-group " + (isX ? "d-none" : "")
                                    }
                                  >
                                    <label className="font-bold" htmlFor="">
                                      <div className="d-flex">
                                        {data.label}
                                        {data.description != undefined ? (
                                          <Tooltip
                                            className="mx-2"
                                            title={data.description}
                                            placement="top-start"
                                          >
                                            <div>
                                              <i className="fa fa-circle-info"></i>
                                            </div>
                                          </Tooltip>
                                        ) : (
                                          ""
                                        )}
                                        {data.required ? (
                                          <span className="required-span">
                                            *
                                          </span>
                                        ) : (
                                          ""
                                        )}
                                      </div>
                                    </label>
                                    <input
                                      id={data?.name.replace("[]", "")}
                                      type="date"
                                      value={
                                        blocks[selectedBlock]?.rooms[
                                          selectedRoom
                                        ] &&
                                          blocks[selectedBlock]?.rooms[
                                          selectedRoom
                                          ][data.name]
                                          ? blocks[selectedBlock]?.rooms[
                                          selectedRoom
                                          ][data.name]
                                          : ""
                                      }
                                      onChange={(e) => {
                                        if (e.target.value.length == 10) {
                                          blockDataSet(
                                            selectedBlock,
                                            data?.name,
                                            e.target.value
                                          );
                                        }
                                      }}
                                      className={
                                        "form-control " +
                                        (validationErrors.includes(data?.name)
                                          ? "error-border"
                                          : "") +
                                        " " +
                                        (allErrors.includes(
                                          data?.name.replace("[]", "")
                                        )
                                          ? "error-border"
                                          : "")
                                      }
                                    />
                                  </div>
                                );
                              } else if (data.type == "select") {
                                return (
                                  <div
                                    className={
                                      "form-group " + (isX ? "d-none" : "")
                                    }
                                  >
                                    <label className="font-bold" htmlFor="">
                                      <div className="d-flex">
                                        {data.label}
                                        {data.description != undefined ? (
                                          <Tooltip
                                            className="mx-2"
                                            title={data.description}
                                            placement="top-start"
                                          >
                                            <div>
                                              <i className="fa fa-circle-info"></i>
                                            </div>
                                          </Tooltip>
                                        ) : (
                                          ""
                                        )}
                                        {data.required ? (
                                          <span className="required-span">
                                            *
                                          </span>
                                        ) : (
                                          ""
                                        )}
                                      </div>
                                    </label>
                                    <select
                                      id={data?.name.replace("[]", "")}
                                      name=""
                                      className={
                                        "form-control " +
                                        (validationErrors.includes(data?.name)
                                          ? "error-border"
                                          : "") +
                                        " " +
                                        (allErrors.includes(
                                          data?.name.replace("[]", "")
                                        )
                                          ? "error-border"
                                          : "")
                                      }
                                      onChange={(e) => {
                                        blockDataSet(
                                          selectedBlock,
                                          data?.name,
                                          e.target.value
                                        );
                                      }}
                                      value={
                                        blocks[selectedBlock]?.rooms[
                                          selectedRoom
                                        ] &&
                                          blocks[selectedBlock]?.rooms[
                                          selectedRoom
                                          ][data.name]
                                          ? blocks[selectedBlock]?.rooms[
                                          selectedRoom
                                          ][data.name]
                                          : ""
                                      }
                                    >
                                      {data.values.map((valueSelect) => {
                                        return (
                                          <option value={valueSelect.value}>
                                            {valueSelect.label}
                                          </option>
                                        );
                                      })}
                                    </select>
                                  </div>
                                );
                              } else if (data.type == "checkbox-group") {
                                if (data.name == "payment-plan[]") {
                                  return (
                                    <div>
                                      <div>
                                        <label
                                          className="mt-3 font-bold"
                                          htmlFor=""
                                        >
                                          <div className="d-flex">
                                            {data.label}
                                            {data.description != undefined ? (
                                              <Tooltip
                                                className="mx-2"
                                                title={data.description}
                                                placement="top-start"
                                              >
                                                <div>
                                                  <i className="fa fa-circle-info"></i>
                                                </div>
                                              </Tooltip>
                                            ) : (
                                              ""
                                            )}
                                            {data.required ? (
                                              <span className="required-span">
                                                *
                                              </span>
                                            ) : (
                                              ""
                                            )}
                                          </div>
                                        </label>
                                        <div
                                          className="checkbox-groups"
                                          id={data?.name.replace("[]", "")}
                                        >
                                          <div className="row">
                                            {data.values.map(
                                              (valueCheckbox) => {
                                                return (
                                                  <div className="col-md-3">
                                                    <FormControlLabel
                                                      control={
                                                        <Switch
                                                          label={
                                                            valueCheckbox.label
                                                          }
                                                          checked={
                                                            blocks[
                                                              selectedBlock
                                                            ]?.rooms[
                                                              selectedRoom
                                                            ] &&
                                                              blocks[
                                                                selectedBlock
                                                              ]?.rooms[
                                                              selectedRoom
                                                              ][data.name] &&
                                                              blocks[
                                                                selectedBlock
                                                              ]?.rooms[
                                                              selectedRoom
                                                              ][data.name] &&
                                                              blocks[
                                                                selectedBlock
                                                              ]?.rooms[
                                                              selectedRoom
                                                              ]
                                                              ? blocks[
                                                                selectedBlock
                                                              ]?.rooms[
                                                                selectedRoom
                                                              ][
                                                                data.name
                                                              ].includes(
                                                                valueCheckbox.value
                                                              )
                                                              : false
                                                          }
                                                          onChange={(e) => {
                                                            blockCheckboxDataSet(
                                                              selectedBlock,
                                                              data?.name,
                                                              valueCheckbox?.value,
                                                              e
                                                            );
                                                            setCheckedItemsFunc(
                                                              data?.name,
                                                              e.target.checked
                                                            );
                                                          }}
                                                        />
                                                      }
                                                      label={
                                                        valueCheckbox.label
                                                      }
                                                    />
                                                  </div>
                                                );
                                              }
                                            )}
                                            {allErrors.includes(
                                              data?.name.replace("[]", "")
                                            ) ? (
                                              <Alert severity="error">
                                                Harita üzerine bir konum seçin
                                              </Alert>
                                            ) : (
                                              ""
                                            )}
                                          </div>
                                        </div>
                                      </div>
                                      <div
                                        className={
                                          "pay-decs mb-3 mt-3 " +
                                          (!(
                                            blocks[selectedBlock] &&
                                            blocks[selectedBlock].rooms[
                                            selectedRoom
                                            ] &&
                                            blocks[selectedBlock].rooms[
                                            selectedRoom
                                            ]["payment-plan[]"] &&
                                            blocks[selectedBlock].rooms[
                                              selectedRoom
                                            ]["payment-plan[]"].includes(
                                              "taksitli"
                                            )
                                          )
                                            ? "d-none"
                                            : "")
                                        }
                                      >
                                        <label htmlFor="" className="font-bold">
                                          Ödeme Planı
                                        </label>
                                        <button
                                          className="btn btn-primary d-block"
                                          onClick={() => {
                                            setPayDecOpen(true);
                                          }}
                                        >
                                          Ödeme Planını Yönet (
                                          {blocks[selectedBlock]?.rooms[
                                            selectedRoom
                                          ]
                                            ? blocks[selectedBlock]?.rooms[
                                              selectedRoom
                                            ]?.payDecs?.length
                                            : 0}
                                          )
                                        </button>
                                      </div>
                                    </div>
                                  );
                                } else {
                                  return (
                                    <div className={isX ? "d-none" : ""}>
                                      <div className="d-flex">
                                        {data.label}
                                        {data.description != undefined ? (
                                          <Tooltip
                                            className="mx-2"
                                            title={data.description}
                                            placement="top-start"
                                          >
                                            <div>
                                              <i className="fa fa-circle-info"></i>
                                            </div>
                                          </Tooltip>
                                        ) : (
                                          ""
                                        )}
                                        {data.required ? (
                                          <span className="required-span">
                                            *
                                          </span>
                                        ) : (
                                          ""
                                        )}
                                      </div>
                                      {data?.className?.includes(
                                        "project-not-change"
                                      ) ? (
                                        <div className="info-small-area">
                                          Bu alan projelerde seçilmesi zorunlu
                                          alandır değiştiremezsiniz
                                        </div>
                                      ) : (
                                        ""
                                      )}
                                      <div className="checkbox-groups">
                                        <div className="row">
                                          {data.values.map((valueCheckbox) => {
                                            return (
                                              <div className="col-md-3">
                                                <FormControlLabel
                                                  control={
                                                    <Checkbox
                                                      checked={
                                                        blocks[selectedBlock]
                                                          ?.rooms[
                                                          selectedRoom
                                                        ] &&
                                                          blocks[selectedBlock]
                                                            ?.rooms[selectedRoom][
                                                          data.name
                                                          ] &&
                                                          blocks[selectedBlock]
                                                            ?.rooms[selectedRoom]
                                                          ? blocks[
                                                            selectedBlock
                                                          ]?.rooms[
                                                            selectedRoom
                                                          ][
                                                            data.name
                                                          ].includes(
                                                            valueCheckbox.value
                                                          )
                                                          : false
                                                      }
                                                      onChange={(e) => {
                                                        if (
                                                          !data?.className?.includes(
                                                            "project-not-change"
                                                          )
                                                        ) {
                                                          blockCheckboxDataSet(
                                                            selectedBlock,
                                                            data?.name,
                                                            valueCheckbox?.value,
                                                            e
                                                          );
                                                          setCheckedItemsFunc(
                                                            data?.name,
                                                            e.target.checked
                                                          );
                                                        }
                                                      }}
                                                    />
                                                  }
                                                  label={valueCheckbox.label}
                                                />
                                              </div>
                                            );
                                          })}
                                        </div>
                                      </div>
                                    </div>
                                  );
                                }
                              } else if (data.type == "file") {
                                return (
                                  <div
                                    className={
                                      "form-group " + (isX ? "d-none" : "")
                                    }
                                  >
                                    <label className="font-bold" htmlFor="">
                                      {data.label}{" "}
                                      {data.required ? (
                                        <span className="required-span">*</span>
                                      ) : (
                                        ""
                                      )}
                                    </label>
                                    <input
                                      id={data?.name.replace("[]", "")}
                                      accept="image/png, image/gif, image/jpeg"
                                      onChange={(event) => {
                                        changeFormImage(
                                          selectedBlock,
                                          data?.name,
                                          event
                                        );
                                      }}
                                      type="file"
                                      className={
                                        "form-control " +
                                        (validationErrors.includes(data?.name)
                                          ? "error-border"
                                          : "") +
                                        " " +
                                        (allErrors.includes(
                                          data?.name.replace("[]", "")
                                        )
                                          ? "error-border"
                                          : "")
                                      }
                                    />
                                    <div className="project_imaget">
                                      <img
                                        src={
                                          blocks[selectedBlock]?.rooms[
                                            selectedRoom
                                          ] &&
                                            blocks[selectedBlock]?.rooms[
                                            selectedRoom
                                            ][data.name + "_imagex"]
                                            ? blocks[selectedBlock]?.rooms[
                                            selectedRoom
                                            ][data.name + "_imagex"]
                                            : ""
                                        }
                                        alt=""
                                      />
                                    </div>
                                  </div>
                                );
                              }
                            }
                          }
                        } else if (
                          slug == "gunluk-kiralik" &&
                          !data?.className?.includes(
                            "only-show-project-rent"
                          ) &&
                          !data?.className?.includes("only-show-project-sale")
                        ) {
                          if (!data?.className?.includes("project-disabled")) {
                            if (
                              !data?.className?.includes(
                                "only-not-show-project"
                              )
                            ) {
                              if (data.type == "text") {
                                return (
                                  <div
                                    className={
                                      "form-group " +
                                      (!(
                                        blocks[selectedBlock] &&
                                        blocks[selectedBlock].rooms[
                                        selectedRoom
                                        ] &&
                                        blocks[selectedBlock].rooms[
                                        selectedRoom
                                        ]["payment-plan[]"] &&
                                        blocks[selectedBlock].rooms[
                                          selectedRoom
                                        ]["payment-plan[]"].includes("taksitli")
                                      ) &&
                                        data.className.includes(
                                          "second-payment-plan"
                                        )
                                        ? "d-none"
                                        : "")
                                    }
                                  >
                                    <label className="font-bold" htmlFor="">
                                      <div className="d-flex">
                                        {data.label}
                                        {data.description != undefined ? (
                                          <Tooltip
                                            className="mx-2"
                                            title={data.description}
                                            placement="top-start"
                                          >
                                            <div>
                                              <i className="fa fa-circle-info"></i>
                                            </div>
                                          </Tooltip>
                                        ) : (
                                          ""
                                        )}
                                        {data.required ? (
                                          <span className="required-span">
                                            *
                                          </span>
                                        ) : (
                                          ""
                                        )}
                                      </div>
                                    </label>
                                    {data?.className?.includes("price-only") ||
                                      data?.className?.includes("number-only") ? (
                                      <input
                                        id={data?.name.replace("[]", "")}
                                        type="text"
                                        value={
                                          blocks[selectedBlock]?.rooms[
                                            selectedRoom
                                          ] &&
                                            blocks[selectedBlock]?.rooms[
                                            selectedRoom
                                            ][data.name]
                                            ? blocks[selectedBlock]?.rooms[
                                            selectedRoom
                                            ][data.name]
                                            : ""
                                        }
                                        onChange={(e) => {
                                          blockDataSet(
                                            selectedBlock,
                                            data?.name,
                                            dotNumberFormat(e.target.value)
                                          );
                                        }}
                                        className={
                                          "form-control " +
                                          (validationErrors.includes(data?.name)
                                            ? "error-border"
                                            : "") +
                                          " " +
                                          (allErrors.includes(
                                            data?.name.replace("[]", "")
                                          )
                                            ? "error-border"
                                            : "")
                                        }
                                      />
                                    ) : data?.className?.includes(
                                      "tel-only"
                                    ) ? (
                                      <input
                                        id={data?.name.replace("[]", "")}
                                        type="text"
                                        value={
                                          blocks[selectedBlock]?.rooms[
                                            selectedRoom
                                          ] &&
                                            blocks[selectedBlock]?.rooms[
                                            selectedRoom
                                            ][data.name]
                                            ? blocks[selectedBlock]?.rooms[
                                            selectedRoom
                                            ][data.name]
                                            : ""
                                        }
                                        onChange={(e) => {
                                          blockDataSet(
                                            selectedBlock,
                                            data?.name,
                                            telNumberFormat(e.target.value)
                                          );
                                        }}
                                        className={
                                          "form-control " +
                                          (validationErrors.includes(data?.name)
                                            ? "error-border"
                                            : "") +
                                          " " +
                                          (allErrors.includes(
                                            data?.name.replace("[]", "")
                                          )
                                            ? "error-border"
                                            : "")
                                        }
                                      />
                                    ) : (
                                      <input
                                        id={data?.name.replace("[]", "")}
                                        type="text"
                                        value={
                                          blocks[selectedBlock]?.rooms[
                                            selectedRoom
                                          ] &&
                                            blocks[selectedBlock]?.rooms[
                                            selectedRoom
                                            ][data.name]
                                            ? blocks[selectedBlock]?.rooms[
                                            selectedRoom
                                            ][data.name]
                                            : ""
                                        }
                                        onChange={(e) => {
                                          blockDataSet(
                                            selectedBlock,
                                            data?.name,
                                            e.target.value
                                          );
                                        }}
                                        className={
                                          "form-control " +
                                          (validationErrors.includes(data?.name)
                                            ? "error-border"
                                            : "") +
                                          " " +
                                          (allErrors.includes(
                                            data?.name.replace("[]", "")
                                          )
                                            ? "error-border"
                                            : "")
                                        }
                                      />
                                    )}
                                  </div>
                                );
                              } else if (data.type == "date") {
                                return (
                                  <div
                                    className={
                                      "form-group " +
                                      (!(
                                        blocks[selectedBlock] &&
                                        blocks[selectedBlock].rooms[
                                        selectedRoom
                                        ] &&
                                        blocks[selectedBlock].rooms[
                                        selectedRoom
                                        ]["payment-plan[]"] &&
                                        blocks[selectedBlock].rooms[
                                          selectedRoom
                                        ]["payment-plan[]"].includes("taksitli")
                                      ) &&
                                        data.className.includes(
                                          "second-payment-plan"
                                        )
                                        ? "d-none"
                                        : "")
                                    }
                                  >
                                    <label className="font-bold" htmlFor="">
                                      <div className="d-flex">
                                        {data.label}
                                        {data.description != undefined ? (
                                          <Tooltip
                                            className="mx-2"
                                            title={data.description}
                                            placement="top-start"
                                          >
                                            <div>
                                              <i className="fa fa-circle-info"></i>
                                            </div>
                                          </Tooltip>
                                        ) : (
                                          ""
                                        )}
                                        {data.required ? (
                                          <span className="required-span">
                                            *
                                          </span>
                                        ) : (
                                          ""
                                        )}
                                      </div>
                                    </label>
                                    <input
                                      id={data?.name.replace("[]", "")}
                                      type="date"
                                      value={
                                        blocks[selectedBlock]?.rooms[
                                          selectedRoom
                                        ] &&
                                          blocks[selectedBlock]?.rooms[
                                          selectedRoom
                                          ][data.name]
                                          ? blocks[selectedBlock]?.rooms[
                                          selectedRoom
                                          ][data.name]
                                          : ""
                                      }
                                      onChange={(e) => {
                                        if (e.target.value.length == 10) {
                                          blockDataSet(
                                            selectedBlock,
                                            data?.name,
                                            e.target.value
                                          );
                                        }
                                      }}
                                      className={
                                        "form-control " +
                                        (validationErrors.includes(data?.name)
                                          ? "error-border"
                                          : "") +
                                        " " +
                                        (allErrors.includes(
                                          data?.name.replace("[]", "")
                                        )
                                          ? "error-border"
                                          : "")
                                      }
                                    />
                                  </div>
                                );
                              } else if (data.type == "select") {
                                return (
                                  <div
                                    className={
                                      "form-group " +
                                      (!(
                                        blocks[selectedBlock] &&
                                        blocks[selectedBlock].rooms[
                                        selectedRoom
                                        ] &&
                                        blocks[selectedBlock].rooms[
                                        selectedRoom
                                        ]["payment-plan[]"] &&
                                        blocks[selectedBlock].rooms[
                                          selectedRoom
                                        ]["payment-plan[]"].includes("taksitli")
                                      ) &&
                                        data.className.includes(
                                          "second-payment-plan"
                                        )
                                        ? "d-none"
                                        : "")
                                    }
                                  >
                                    <label className="font-bold" htmlFor="">
                                      <div className="d-flex">
                                        {data.label}
                                        {data.description != undefined ? (
                                          <Tooltip
                                            className="mx-2"
                                            title={data.description}
                                            placement="top-start"
                                          >
                                            <div>
                                              <i className="fa fa-circle-info"></i>
                                            </div>
                                          </Tooltip>
                                        ) : (
                                          ""
                                        )}
                                        {data.required ? (
                                          <span className="required-span">
                                            *
                                          </span>
                                        ) : (
                                          ""
                                        )}
                                      </div>
                                    </label>
                                    <select
                                      id={data?.name.replace("[]", "")}
                                      name=""
                                      className={
                                        "form-control " +
                                        (validationErrors.includes(data?.name)
                                          ? "error-border"
                                          : "") +
                                        " " +
                                        (allErrors.includes(
                                          data?.name.replace("[]", "")
                                        )
                                          ? "error-border"
                                          : "")
                                      }
                                      onChange={(e) => {
                                        blockDataSet(
                                          selectedBlock,
                                          data?.name,
                                          e.target.value
                                        );
                                      }}
                                      value={
                                        blocks[selectedBlock]?.rooms[
                                          selectedRoom
                                        ] &&
                                          blocks[selectedBlock]?.rooms[
                                          selectedRoom
                                          ][data.name]
                                          ? blocks[selectedBlock]?.rooms[
                                          selectedRoom
                                          ][data.name]
                                          : ""
                                      }
                                    >
                                      {data.values.map((valueSelect) => {
                                        return (
                                          <option value={valueSelect.value}>
                                            {valueSelect.label}
                                          </option>
                                        );
                                      })}
                                    </select>
                                  </div>
                                );
                              } else if (data.type == "checkbox-group") {
                                if (data.name == "payment-plan[]") {
                                  return (
                                    <div>
                                      <div>
                                        <label
                                          className="mt-3 font-bold"
                                          htmlFor=""
                                        >
                                          <div className="d-flex">
                                            {data.label}
                                            {data.description != undefined ? (
                                              <Tooltip
                                                className="mx-2"
                                                title={data.description}
                                                placement="top-start"
                                              >
                                                <div>
                                                  <i className="fa fa-circle-info"></i>
                                                </div>
                                              </Tooltip>
                                            ) : (
                                              ""
                                            )}
                                            {data.required ? (
                                              <span className="required-span">
                                                *
                                              </span>
                                            ) : (
                                              ""
                                            )}
                                          </div>
                                        </label>
                                        <div
                                          className="checkbox-groups"
                                          id={data?.name.replace("[]", "")}
                                        >
                                          <div className="row">
                                            {data.values.map(
                                              (valueCheckbox) => {
                                                return (
                                                  <div className="col-md-3">
                                                    <FormControlLabel
                                                      control={
                                                        <Switch
                                                          label={
                                                            valueCheckbox.label
                                                          }
                                                          checked={
                                                            blocks[
                                                              selectedBlock
                                                            ]?.rooms[
                                                              selectedRoom
                                                            ] &&
                                                              blocks[
                                                                selectedBlock
                                                              ]?.rooms[
                                                              selectedRoom
                                                              ][data.name] &&
                                                              blocks[
                                                                selectedBlock
                                                              ]?.rooms[
                                                              selectedRoom
                                                              ][data.name] &&
                                                              blocks[
                                                                selectedBlock
                                                              ]?.rooms[
                                                              selectedRoom
                                                              ]
                                                              ? blocks[
                                                                selectedBlock
                                                              ]?.rooms[
                                                                selectedRoom
                                                              ][
                                                                data.name
                                                              ].includes(
                                                                valueCheckbox.value
                                                              )
                                                              : false
                                                          }
                                                          onChange={(e) => {
                                                            blockCheckboxDataSet(
                                                              selectedBlock,
                                                              data?.name,
                                                              valueCheckbox?.value,
                                                              e
                                                            );
                                                          }}
                                                        />
                                                      }
                                                      label={
                                                        valueCheckbox.label
                                                      }
                                                    />
                                                  </div>
                                                );
                                              }
                                            )}
                                            {allErrors.includes(
                                              data?.name.replace("[]", "")
                                            ) ? (
                                              <Alert severity="error">
                                                Harita üzerine bir konum seçin
                                              </Alert>
                                            ) : (
                                              ""
                                            )}
                                          </div>
                                        </div>
                                      </div>
                                      <div
                                        className={
                                          "pay-decs mb-3 mt-3 " +
                                          (!(
                                            blocks[selectedBlock] &&
                                            blocks[selectedBlock].rooms[
                                            selectedRoom
                                            ] &&
                                            blocks[selectedBlock].rooms[
                                            selectedRoom
                                            ]["payment-plan[]"] &&
                                            blocks[selectedBlock].rooms[
                                              selectedRoom
                                            ]["payment-plan[]"].includes(
                                              "taksitli"
                                            )
                                          )
                                            ? "d-none"
                                            : "")
                                        }
                                      >
                                        <label htmlFor="" className="font-bold">
                                          Ödeme Planı
                                        </label>
                                        <button
                                          className="btn btn-primary d-block"
                                          onClick={() => {
                                            setPayDecOpen(true);
                                          }}
                                        >
                                          Ödeme Planını Yönet (
                                          {blocks[selectedBlock]?.rooms[
                                            selectedRoom
                                          ]
                                            ? blocks[selectedBlock]?.rooms[
                                              selectedRoom
                                            ]?.payDecs?.length
                                            : 0}
                                          )
                                        </button>
                                      </div>
                                    </div>
                                  );
                                } else {
                                  return (
                                    <div>
                                      <div className="d-flex">
                                        {data.label}
                                        {data.description != undefined ? (
                                          <Tooltip
                                            className="mx-2"
                                            title={data.description}
                                            placement="top-start"
                                          >
                                            <div>
                                              <i className="fa fa-circle-info"></i>
                                            </div>
                                          </Tooltip>
                                        ) : (
                                          ""
                                        )}
                                        {data.required ? (
                                          <span className="required-span">
                                            *
                                          </span>
                                        ) : (
                                          ""
                                        )}
                                      </div>
                                      {data?.className?.includes(
                                        "project-not-change"
                                      ) ? (
                                        <div className="info-small-area">
                                          Bu alan projelerde seçilmesi zorunlu
                                          alandır değiştiremezsiniz
                                        </div>
                                      ) : (
                                        ""
                                      )}
                                      <div className="checkbox-groups">
                                        <div className="row">
                                          {data.values.map((valueCheckbox) => {
                                            return (
                                              <div className="col-md-3">
                                                <FormControlLabel
                                                  control={
                                                    <Checkbox
                                                      checked={
                                                        blocks[selectedBlock]
                                                          ?.rooms[
                                                          selectedRoom
                                                        ] &&
                                                          blocks[selectedBlock]
                                                            ?.rooms[selectedRoom][
                                                          data.name
                                                          ] &&
                                                          blocks[selectedBlock]
                                                            ?.rooms[selectedRoom]
                                                          ? blocks[
                                                            selectedBlock
                                                          ]?.rooms[
                                                            selectedRoom
                                                          ][
                                                            data.name
                                                          ].includes(
                                                            valueCheckbox.value
                                                          )
                                                          : false
                                                      }
                                                      onChange={(e) => {
                                                        if (
                                                          !data?.className?.includes(
                                                            "project-not-change"
                                                          )
                                                        ) {
                                                          blockCheckboxDataSet(
                                                            selectedBlock,
                                                            data?.name,
                                                            valueCheckbox?.value,
                                                            e
                                                          );
                                                          setCheckedItemsFunc(
                                                            data?.name,
                                                            e.target.checked
                                                          );
                                                        }
                                                      }}
                                                    />
                                                  }
                                                  label={valueCheckbox.label}
                                                />
                                              </div>
                                            );
                                          })}
                                        </div>
                                      </div>
                                    </div>
                                  );
                                }
                              } else if (data.type == "file") {
                                return (
                                  <div className="form-group">
                                    <label className="font-bold" htmlFor="">
                                      {data.label}{" "}
                                      {data.required ? (
                                        <span className="required-span">*</span>
                                      ) : (
                                        ""
                                      )}
                                    </label>
                                    <input
                                      id={data?.name.replace("[]", "")}
                                      accept="image/png, image/gif, image/jpeg"
                                      onChange={(event) => {
                                        changeFormImage(
                                          selectedBlock,
                                          data?.name,
                                          event
                                        );
                                      }}
                                      type="file"
                                      className={
                                        "form-control " +
                                        (validationErrors.includes(data?.name)
                                          ? "error-border"
                                          : "") +
                                        " " +
                                        (allErrors.includes(
                                          data?.name.replace("[]", "")
                                        )
                                          ? "error-border"
                                          : "")
                                      }
                                    />
                                    <div className="project_imaget">
                                      <img
                                        src={
                                          blocks[selectedBlock]?.rooms[
                                            selectedRoom
                                          ] &&
                                            blocks[selectedBlock]?.rooms[
                                            selectedRoom
                                            ][data.name + "_imagex"]
                                            ? blocks[selectedBlock]?.rooms[
                                            selectedRoom
                                            ][data.name + "_imagex"]
                                            : ""
                                        }
                                        alt=""
                                      />
                                    </div>
                                  </div>
                                );
                              }
                            }
                          }
                        }
                      })}
                    </div>
                  ) : (
                    ""
                  )}
                </div>
              </div>
            </div>
          </div>

          <PayDecModal
            open={payDecOpen}
            blocks={blocks}
            setBlocks={setBlocks}
            selectedBlock={selectedBlock}
            selectedRoom={selectedRoom}
            setOpen={setPayDecOpen}
          />
        </>
      )}
    </>
  );
}
export default Rooms;
