import axios from 'axios';
import React, { useEffect, useState } from 'react';
import { baseUrl } from '../../define/variables';

function TypeList2({
  setSlug,
  setSelectedHousingType,
  selectedHousingType,
  setSelectedTypes,
  selectedTypes,
  nextStep,
  housingTypes,
  setHousingTypes,
  setSelectedTypesTitles,
  selectedTypesTitles,
}) {
  const [loadingOrder, setLoadingOrder] = useState(null);
  const [loadingOrderStatusId, setLoadingOrderStatusId] = useState(null);

  useEffect(() => {
    if (housingTypes.length === 0) {
      axios.get(baseUrl + 'housing_types').then((res) => {
        setHousingTypes([res.data.data]);
      });
    }
  }, [setHousingTypes, housingTypes]);

  const setHousingTypeParent = (housingTypeId, order) => {
    const tempHousingTypeParents = [...selectedTypes.slice(0, order), housingTypeId];
    setLoadingOrder(order);
    setLoadingOrderStatusId(housingTypeId);
    setSelectedTypes(tempHousingTypeParents);

    const endpoint = order === 1 ? 'housing_types_end' : 'housing_types';
    axios
      .get(`${baseUrl}${endpoint}?parent_id=${housingTypeId}`)
      .then((res) => {
        const newHousingTypes = [...housingTypes.slice(0, order + 1), res.data.data];
        setLoadingOrder(null);
        setLoadingOrderStatusId(null);
        setHousingTypes(newHousingTypes);
      });
  };

  const setHousingTypeTitles = (housingTypeTitle, order) => {
    const tempHousingTypeTitles = [...selectedTypesTitles.slice(0, order), housingTypeTitle];
    setSelectedTypesTitles(tempHousingTypeTitles);
  };

  return (
    <div>
      <div className="container mt-5">
        <div className="row">
          {housingTypes[0] && (
            <div className="area-list active">
              <ul>
                {housingTypes[0].map((housingType) => (
                  <li
                    key={housingType.id}
                    onClick={() => {
                      setHousingTypeParent(housingType.id, 0);
                      setHousingTypeTitles(housingType.title, 0);
                    }}
                    className={selectedTypes[0] === housingType.id ? 'selected' : ''}
                  >
                    {housingType?.title}
                    {loadingOrder === 0 && loadingOrderStatusId === housingType.id && (
                      <div className="loading-icon">
                        <i className="fa fa-spinner"></i>
                      </div>
                    )}
                  </li>
                ))}
              </ul>
            </div>
          )}
          {selectedTypes[0] && housingTypes[1] && (
            <div className="area-list active">
              <ul>
                {housingTypes[1].map((housingType) => (
                  <li
                    key={housingType.id}
                    onClick={() => {
                      setHousingTypeParent(housingType.id, 1);
                      setSlug(housingType.slug);
                      setHousingTypeTitles(housingType.title, 1);
                    }}
                    className={selectedTypes[1] === housingType.id ? 'selected' : ''}
                  >
                    {housingType?.title}
                    {loadingOrder === 1 && loadingOrderStatusId === housingType.id && (
                      <div className="loading-icon">
                        <i className="fa fa-spinner"></i>
                      </div>
                    )}
                  </li>
                ))}
              </ul>
            </div>
          )}
          {selectedTypes[1] && housingTypes[2] && (
            <div className="area-list active">
              <ul>
                {housingTypes[2].map((housingType) => (
                  <li
                    key={housingType.id}
                    onClick={() => {
                      setSelectedHousingType(housingType);
                      setHousingTypeParent(housingType.id, 2);
                      setHousingTypeTitles(housingType?.housing_type?.title, 2);
                    }}
                    className={selectedTypes[2] === housingType.id ? 'selected' : ''}
                  >
                    {housingType?.housing_type?.title}
                  </li>
                ))}
              </ul>
            </div>
          )}
          {selectedTypes[2] && (
            <div className="area-list active last-contunie-step">
              <div className="finish-category-select">
                <div className="finish-icon-area">
                  <i className="fa fa-check"></i>
                </div>
                <div className="finish-text">
                  <p>Kategori Seçimi Tamamlanmıştır</p>
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

export default TypeList2;
