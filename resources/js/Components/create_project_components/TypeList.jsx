import axios from "axios";
import React, { useEffect, useState } from "react";
import { baseUrl } from "../../define/variables";
function TypeList({
  setSlug,
  setSelectedHousingType,
  setSelectedTypes,
  selectedTypes,
  nextStep,
  housingTypes,
  setHousingTypes,
  selectedTypesTitles,
  setSelectedTypesTitles,
}) {
  const [housingStatuses, setHousingStatuses] = React.useState([]);
  const [loadingOrder, setLoadingOrder] = React.useState(null);
  const [loadingOrderStatusId, setLoadingOrderStatusId] = React.useState(null);

  React.useEffect(() => {
    axios.get(baseUrl + "get_housing_statuses").then((res) => {
      setHousingStatuses(res.data.data);
    });

    axios.get(baseUrl + "housing_types").then((res) => {
      setHousingTypes([res.data.data]);
    });
  }, []);

  const setHousingStatus = (statusId) => {
    setSelectedTypes([statusId]);
  };

  const setHousingTypeParent = (housingTypeId, order) => {
    var tempHousingTypeParents = [];

    for (var i = 0; i <= order; i++) {
      if (i == order) {
        tempHousingTypeParents.push(housingTypeId);
      } else {
        tempHousingTypeParents.push(selectedTypes[i]);
      }
    }
    setLoadingOrder(order);
    setLoadingOrderStatusId(housingTypeId);
    setSelectedTypes(tempHousingTypeParents);
    if (order == 2) {
      axios
        .get(baseUrl + "housing_types_end?parent_id=" + housingTypeId)
        .then((res) => {
          var tempHousingTypeParents = [];
          for (var i = 0; i <= order; i++) {
            if (i == order) {
              tempHousingTypeParents.push(res.data.data);
            } else {
              tempHousingTypeParents.push(housingTypes[i]);
            }
          }
          setLoadingOrder(null);
          setLoadingOrderStatusId(null);
          setHousingTypes(tempHousingTypeParents);
        });
    } else {
      axios
        .get(baseUrl + "housing_types?parent_id=" + housingTypeId)
        .then((res) => {
          var tempHousingTypeParents = [];
          for (var i = 0; i <= order; i++) {
            if (i == order) {
              tempHousingTypeParents.push(res.data.data);
            } else {
              tempHousingTypeParents.push(housingTypes[i]);
            }
          }

          setLoadingOrder(null);
          setLoadingOrderStatusId(null);
          setHousingTypes(tempHousingTypeParents);
        });
    }
  };

  const setHousingTypeTitles = (housingTypeTitle, order) => {
    var tempHousingTypeParents = [];

    for (var i = 0; i <= order; i++) {
      if (i == order) {
        tempHousingTypeParents.push(housingTypeTitle);
      } else {
        tempHousingTypeParents.push(selectedTypesTitles[i]);
      }
    }

    setSelectedTypesTitles(tempHousingTypeParents);
  };
  useEffect(() => {
    const fetchHousingTypes = async () => {
      if (selectedTypes[1]) {
        const res1 = await axios.get(
          `${baseUrl}housing_types?parent_id=${selectedTypes[1]}`
        );
        setHousingTypes((prev) => [prev[0], res1.data.data]);
      }

      if (selectedTypes[2]) {
        const res2 = await axios.get(
          `${baseUrl}housing_types_end?parent_id=${selectedTypes[2]}`
        );
        setHousingTypes((prev) => [prev[0], prev[1], res2.data.data]);
      }
    };

    fetchHousingTypes();
  }, [selectedTypes]);
  return (
    <div>
      <div className="container mt-5">
        <div className="row" style={{ flexWrap: "nowrap" }}>
          {housingStatuses.length > 0 && (
            <div className="area-list active">
              <ul>
                {housingStatuses
                  .sort((a, b) => a.name.localeCompare(b.name, "tr"))
                  .map((housingStatus) => {
                    if (!housingStatus.is_default) {
                      return (
                        <li
                          onClick={() => {
                            setHousingStatus(housingStatus.id);
                            setHousingTypeTitles(housingStatus.name, 0);
                          }}
                          className={
                            selectedTypes[0] == housingStatus.id
                              ? "selected"
                              : ""
                          }
                        >
                          {housingStatus.name}
                        </li>
                      );
                    }
                  })}
              </ul>
            </div>
          )}

          {selectedTypes[0] && housingTypes[0] ? (
            <div className="area-list active">
              <ul>
                {housingTypes[0].map((housingType) => {
                  return (
                    <li
                      onClick={() => {
                        setHousingTypeParent(housingType.id, 1);
                        setHousingTypeTitles(housingType.title, 1);
                      }}
                      className={
                        selectedTypes[1] == housingType.id ? "selected" : ""
                      }
                    >
                      {housingType.title}
                      {loadingOrder &&
                      loadingOrder == 1 &&
                      loadingOrderStatusId &&
                      loadingOrderStatusId == housingType.id ? (
                        <div className="loading-icon">
                          <i className="fa fa-spinner"></i>
                        </div>
                      ) : (
                        ""
                      )}
                    </li>
                  );
                })}
              </ul>
            </div>
          ) : (
            ""
          )}
          {selectedTypes[1] && housingTypes[1] ? (
            <div className="area-list active">
              <ul>
                {housingTypes[1]?.map((housingType) => {
                  return (
                    <li
                      onClick={() => {
                        setHousingTypeParent(housingType.id, 2);
                        setSlug(housingType.slug);
                        setHousingTypeTitles(housingType.title, 2);
                      }}
                      className={
                        selectedTypes[2] == housingType.id ? "selected" : ""
                      }
                    >
                      {housingType.title}
                      {loadingOrder &&
                      loadingOrder == 2 &&
                      loadingOrderStatusId &&
                      housingType.id == loadingOrderStatusId ? (
                        <div className="loading-icon">
                          <i className="fa fa-spinner"></i>
                        </div>
                      ) : (
                        ""
                      )}
                    </li>
                  );
                })}
              </ul>
            </div>
          ) : (
            ""
          )}
          {selectedTypes[2] && housingTypes[2] ? (
            <div className="area-list active">
              <ul>
                {housingTypes[2]?.map((housingType) => {
                  return (
                    <li
                      onClick={() => {
                        setSelectedHousingType(housingType);
                        setHousingTypeParent(housingType.id, 3);
                        setHousingTypeTitles(
                          housingType?.housing_type?.title,
                          3
                        );
                      }}
                      className={
                        selectedTypes[3] == housingType.id ? "selected" : ""
                      }
                    >
                      {housingType?.housing_type?.title}
                    </li>
                  );
                })}
              </ul>
            </div>
          ) : (
            ""
          )}
          {selectedTypes[3] && (
            <div className="area-list active">
              <div className="finish-category-select">
                <div className="finish-icon-area">
                  <i className="fa fa-check"></i>
                </div>
                <div className="finish-text">
                  <p>Kategori Seçimi Tamanlanmıştır</p>
                </div>
                <div className="finish-button-first">
                  <button
                    onClick={nextStep}
                    className="btn btn-danger"
                    style={{ backgroundColor: 'green', border: 'green' }}
                  >
                    Devam
                  </button>
                </div>
              </div>
            </div>
          )}
        </div>
      </div>
    </div>
  );
}
export default TypeList;
