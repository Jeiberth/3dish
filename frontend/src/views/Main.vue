<template>
  <main class="menu-view">
    <header class="view-header">
      <div class="container header-container my-0 my-md-4">
        <div class="search-bar">
          <svg class="icon" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z" clip-rule="evenodd" />
          </svg>
          <input
            v-model="searchTerm"
            :placeholder="$t('main.search')"
            class="search-input"
            type="text"
          />
          <button
            v-if="searchTerm"
            @click="clearSearch"
            class="clear-btn"
            aria-label="Clear search"
          >
            <svg viewBox="0 0 20 20" fill="currentColor">
              <path d="M6.28 5.22a.75.75 0 00-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 101.06 1.06L10 11.06l3.72 3.72a.75.75 0 101.06-1.06L11.06 10l3.72-3.72a.75.75 0 00-1.06-1.06L10 8.94 6.28 5.22z" />
            </svg>
          </button>
        </div>

        <button
          @click="toggleFilters"
          class="filter-toggle-btn hoverAnimation"
          :class="{ 'is-active': showFilters }"
          :aria-pressed="showFilters"
        >
          <svg class="icon" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M2.628 1.601C5.028 1.206 7.49 1 10 1s4.973.206 7.372.601a.75.75 0 01.628.74v2.288a2.25 2.25 0 01-.659 1.59l-4.682 4.683a2.25 2.25 0 00-.659 1.59v3.037c0 .684-.31 1.33-.844 1.757l-1.937 1.55A.75.75 0 018 18.25v-5.757a2.25 2.25 0 00-.659-1.591L2.659 6.22A2.25 2.25 0 012 4.629V2.34a.75.75 0 01.628-.74z" clip-rule="evenodd" />
          </svg>
          <span>{{ $t('main.filters.f') }}</span>
          <span v-if="activeFiltersCount" class="badge">{{ activeFiltersCount }}</span>
        </button>
      </div>
    </header>

    <!-- Filter drawer moved outside of the sticky header -->
    <Transition name="slide-fade">
      <section v-if="showFilters" class="filter-drawer">
        <div class="container">
          <div class="filter-grid">
            <fieldset class="filter-group">
              <legend class="filter-label">{{ $t('main.filters.price') }}</legend>
              <div class="filter-range">
                <input v-model.number="filters.priceMin" type="number" :placeholder="$t('main.filters.minPrice')" class="range-input" min="0" step="0.01" />
                <span class="range-separator">-</span>
                <input v-model.number="filters.priceMax" type="number" :placeholder="$t('main.filters.maxPrice')" class="range-input" min="0" step="0.01" />
              </div>
            </fieldset>

            <fieldset class="filter-group">
              <legend class="filter-label">{{ $t('main.filters.calories') }}</legend>
              <div class="filter-range">
                <input v-model.number="filters.caloriesMin" type="number" :placeholder="$t('main.filters.minCalories')" class="range-input" min="0" />
                <span class="range-separator">-</span>
                <input v-model.number="filters.caloriesMax" type="number" :placeholder="$t('main.filters.maxCalories')" class="range-input" min="0" />
              </div>
            </fieldset>

            <fieldset class="filter-group">
              <legend class="filter-label">{{ $t('main.filters.spiciness') }}</legend>
              <div class="filter-options">
                <label v-for="spice in spicyLevels" :key="spice" class="filter-chip">
                  <input v-model="filters.spiciness" :value="spice" type="checkbox" />
                  <span>{{ spice }}</span>
                </label>
              </div>
            </fieldset>

            <fieldset class="filter-group">
              <legend class="filter-label">{{ $t('main.filters.size') }}</legend>
              <div class="filter-options">
                <label v-for="size in sizes" :key="size" class="filter-chip">
                  <input v-model="filters.sizes" :value="size" type="checkbox" />
                  <span>{{ size }}</span>
                </label>
              </div>
            </fieldset>

            <fieldset class="filter-group">
              <legend class="filter-label">{{ $t('main.filters.dietary') }}</legend>
              <div class="filter-options">
                <label v-for="dietary in allDietaries" :key="dietary" class="filter-chip">
                  <input v-model="filters.dietaries" :value="dietary" type="checkbox" />
                  <span>{{ dietary }}</span>
                </label>
              </div>
            </fieldset>

            <fieldset class="filter-group">
              <legend class="filter-label">{{ $t('main.filters.allergens') }}</legend>
              <div class="filter-options">
                <label v-for="allergen in allAllergens" :key="allergen" class="filter-chip">
                  <input v-model="filters.allergens" :value="allergen" type="checkbox" />
                  <span>{{ allergen }}</span>
                </label>
              </div>
            </fieldset>

            <fieldset class="filter-group">
              <legend class="filter-label">{{ $t('main.filters.proteins') }}</legend>
              <div class="filter-options">
                <label v-for="protein in allProteins" :key="protein" class="filter-chip">
                  <input v-model="filters.proteins" :value="protein" type="checkbox" />
                  <span>{{ protein }}</span>
                </label>
              </div>
            </fieldset>

            <fieldset class="filter-group">
              <legend class="filter-label">{{ $t('main.filters.tasteProfiles') }}</legend>
              <div class="filter-options">
                <label v-for="taste in allTasteProfiles" :key="taste" class="filter-chip">
                  <input v-model="filters.tasteProfiles" :value="taste" type="checkbox" />
                  <span>{{ taste }}</span>
                </label>
              </div>
            </fieldset>
          </div>

          <footer class="filter-actions">
            <p class="results-summary">
              {{ $t('main.filters.resultsCount', { count: totalFilteredDishes }) }}
            </p>
            <button @click="clearAllFilters" class="btn-secondary">
              {{ $t('main.filters.clearAll') }}
            </button>
          </footer>
        </div>
      </section>
    </Transition>

    <div class="view-content">
      <div class="container mt-3">
        <div v-if="filteredDishGroups.length === 0" class="no-results-placeholder">
          <div class="icon-wrapper">
            <svg viewBox="0 0 20 20" fill="currentColor">
              <path fill-rule="evenodd" d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z" clip-rule="evenodd" />
            </svg>
          </div>
          <h3>{{ $t('main.noResults.title') }}</h3>
          <p>{{ $t('main.noResults.message') }}</p>
        </div>

        <header @click="selectedGroup = null; showDishGroupModal = true" class="category-header mt-3" style="cursor: pointer;"    >
            <h2  class="category-title">
                {{ $t('+ Add New Dish Group') }}
            </h2>
        </header>

        <section v-for="group in filteredDishGroups" :key="group.id" class="category-section">
          <header class="category-header" @click="toggleGroup(group.id)">
            <h2 class="category-title">
                {{ group.name[$i18n.locale] || group.name.en || 'Untitled Group' }}
                <i      @click.stop="openDishGroupModal(group)" style="cursor: pointer" class="fa-solid fa-pencil" ></i>
            </h2>
            <div>
                <button
                     @click.stop="openNewDish(group)"
                    class="hoverAnimation ms-3"

                    style="background-color: rgba(236, 236, 236, 0.718); border-radius: 50px; color: black; border: 0px; padding: 12px; font-weight: 700;"
                >
                    +<i class="fa-solid fa-burger"></i>
                </button>
                <span class="category-count">
                    {{ filteredDishes(group.dishes).length }} {{ $t('main.dishes') }}

                    <i
                        class="fa-solid"
                        :class="expandedGroups.has(group.id) ? 'fa-angle-up' : 'fa-angle-down'"
                        @click.stop="toggleGroup(group.id)"
                        style="transition: transform 0.2s ease; color: black; margin-left: 10px; font-size: 24px; cursor: pointer;"
                    ></i>
                </span>
            </div>
          </header>
            <div style="display: flex; flex-direction: column;" v-if="expandedGroups.has(group.id)">
            <Dish
              v-for="dish in filteredDishes(group.dishes)"
              :key="dish.id"
              :dish="dish"
              @click="openDishModal(dish)"
            />
            </div>
        </section>


      </div>
    </div>

    <DishGroupModal
      v-if="showDishGroupModal"
      :dishGroup="selectedGroup"
      @close="closeDishGroupModal"
      @updated="onDishGroupUpdated"
      @deleted="onDishGroupDeleted"
      @created="onDishGroupCreated"
    />

    <DishModal
      v-if="showDishModal"
      :dish="selectedDish"
      :dish_group_id="dish_group_id_for_creation"
      @close="closeDishModal"
      @created="onDishCreated"
      @updated="onDishUpdated"
      @deleted="onDishDeleted"
    />

  </main>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue';
import { useI18n } from 'vue-i18n';
import { MenuResource } from '../api/MenuResource';
import Dish from '../components/Dish.vue';
import DishModal from '../components/DishModal.vue';
import DishGroupModal from '../components/DishGroupModal.vue';

const { t } = useI18n();
const menuResource = new MenuResource();

// Data
const searchTerm = ref('');
const dishGroups = ref([]);
const showFilters = ref(false);
const showDishGroupModal = ref(false);
const showDishModal = ref(false);
const selectedGroup = ref(null);
const selectedDish = ref(null);

// Filter state
const filters = ref({
  priceMin: null,
  priceMax: null,
  caloriesMin: null,
  caloriesMax: null,
  spiciness: [],
  sizes: [],
  dietaries: [],
  allergens: [],
  proteins: [],
  tasteProfiles: []
});

const expandedGroups = ref(new Set())

// Toggles whether the group is expanded or collapsed
const toggleGroup = (groupId) => {
  if (expandedGroups.value.has(groupId)) {
    expandedGroups.value.delete(groupId)
  } else {
    expandedGroups.value.add(groupId)
  }
}

const dish_group_id_for_creation = ref(null);

function openNewDish(group){
    showDishModal.value = true;
    dish_group_id_for_creation.value = group.id;
}

const onDishCreated = (newDish) => {
  // Find the dish group where the new dish belongs
  const groupIndex = dishGroups.value.findIndex(
    (group) => group.id === dish_group_id_for_creation.value
  );

  if (groupIndex !== -1) {
    // Ensure the dishes array exists
    if (!dishGroups.value[groupIndex].dishes) {
      dishGroups.value[groupIndex].dishes = [];
    }
    // Add the new dish to the group's dishes array
    dishGroups.value[groupIndex].dishes.push(newDish);
  }

  // Reset the modal and dish_group_id_for_creation
  closeDishModal();
  dish_group_id_for_creation.value = null;
};

const onDishGroupCreated = (newDishGroup) => {
    dishGroups.value.push(newDishGroup);
};


// Filter options (computed from data)
const spicyLevels = computed(() => {
  const levels = new Set();
  dishGroups.value.forEach(group => {
    group.dishes?.forEach(dish => {
      if (dish.spicy) levels.add(dish.spicy);
    });
  });
  return Array.from(levels).sort();
});

const sizes = computed(() => {
  const sizeSet = new Set();
  dishGroups.value.forEach(group => {
    group.dishes?.forEach(dish => {
      if (dish.size) sizeSet.add(dish.size);
    });
  });
  return Array.from(sizeSet).sort();
});

function toggleFilters() {
    showFilters.value = !showFilters.value;
    window.scrollTo({
        top: 0,
        behavior: 'smooth' // optional: makes the scroll smooth
    });
}

const allDietaries = computed(() => {
  const dietariesSet = new Set();
  dishGroups.value.forEach(group => {
    group.dishes?.forEach(dish => {
      dish.dietaries?.forEach(dietary => {
        dietariesSet.add(dietary.name);
      });
    });
  });
  return Array.from(dietariesSet).sort();
});

const allAllergens = computed(() => {
  const allergensSet = new Set();
  dishGroups.value.forEach(group => {
    group.dishes?.forEach(dish => {
      dish.allergens?.forEach(allergen => {
        allergensSet.add(allergen.name);
      });
    });
  });
  return Array.from(allergensSet).sort();
});

const allProteins = computed(() => {
  const proteinsSet = new Set();
  dishGroups.value.forEach(group => {
    group.dishes?.forEach(dish => {
      dish.proteins?.forEach(protein => {
        proteinsSet.add(protein.name);
      });
    });
  });
  return Array.from(proteinsSet).sort();
});



const allTasteProfiles = computed(() => {
  const tastesSet = new Set();
  dishGroups.value.forEach(group => {
    group.dishes?.forEach(dish => {
      dish.taste_profiles?.forEach(taste => {
        tastesSet.add(taste.name);
      });
    });
  });
  return Array.from(tastesSet).sort();
});

// Computed properties
const activeFiltersCount = computed(() => {
  let count = 0;
  if (filters.value.priceMin !== null || filters.value.priceMax !== null) count++;
  if (filters.value.caloriesMin !== null || filters.value.caloriesMax !== null) count++;
  if (filters.value.spiciness.length) count++;
  if (filters.value.sizes.length) count++;
  if (filters.value.dietaries.length) count++;
  if (filters.value.allergens.length) count++;
  if (filters.value.proteins.length) count++;
  if (filters.value.tasteProfiles.length) count++;
  return count;
});

const totalFilteredDishes = computed(() => {
  return filteredDishGroups.value.reduce((total, group) => {
    return total + filteredDishes(group.dishes).length;
  }, 0);
});

// Filter functions
const matchesSearch = (dish) => {
  if (!searchTerm.value) return true;
  const term = searchTerm.value.toLowerCase();
  const nameMatch = Object.values(dish.name || {}).some(name => name?.toLowerCase().includes(term));
  const descMatch = Object.values(dish.description || {}).some(desc => desc?.toLowerCase().includes(term));
  return nameMatch || descMatch;
};

const matchesFilters = (dish) => {
  if (filters.value.priceMin !== null && parseFloat(dish.price) < filters.value.priceMin) return false;
  if (filters.value.priceMax !== null && parseFloat(dish.price) > filters.value.priceMax) return false;
  if (filters.value.caloriesMin !== null && dish.calories < filters.value.caloriesMin) return false;
  if (filters.value.caloriesMax !== null && dish.calories > filters.value.caloriesMax) return false;
  if (filters.value.spiciness.length && !filters.value.spiciness.includes(dish.spicy)) return false;
  if (filters.value.sizes.length && !filters.value.sizes.includes(dish.size)) return false;
  if (filters.value.dietaries.length) {
    const dishDietaries = dish.dietaries?.map(d => d.name) || [];
    if (!filters.value.dietaries.some(dietary => dishDietaries.includes(dietary))) return false;
  }
  if (filters.value.allergens.length) {
    const dishAllergens = dish.allergens?.map(a => a.name) || [];
    if (filters.value.allergens.some(allergen => dishAllergens.includes(allergen))) return false;
  }
  if (filters.value.proteins.length) {
    const dishProteins = dish.proteins?.map(p => p.name) || [];
    if (!filters.value.proteins.some(protein => dishProteins.includes(protein))) return false;
  }
  if (filters.value.tasteProfiles.length) {
    const dishTastes = dish.taste_profiles?.map(t => t.name) || [];
    if (!filters.value.tasteProfiles.some(taste => dishTastes.includes(taste))) return false;
  }
  return true;
};

const filteredDishes = (dishes) => {
  if (!dishes) return [];
  return dishes.filter(dish => matchesSearch(dish) && matchesFilters(dish));
};

const filteredDishGroups = computed(() => {
  return dishGroups.value
    .map(group => ({
      ...group,
      dishes: filteredDishes(group.dishes)
    }))
});

// Methods
const clearSearch = () => {
  searchTerm.value = '';
};

const clearAllFilters = () => {
  filters.value = {
    priceMin: null,
    priceMax: null,
    caloriesMin: null,
    caloriesMax: null,
    spiciness: [],
    sizes: [],
    dietaries: [],
    allergens: [],
    proteins: [],
    tasteProfiles: []
  };
};

const openDishGroupModal = (group) => {
  selectedGroup.value = { ...group };
  showDishGroupModal.value = true;
};

const closeDishGroupModal = () => {
  showDishGroupModal.value = false;
  selectedGroup.value = null;
};

const openDishModal = (dish) => {
  selectedDish.value = { ...dish };
  showDishModal.value = true;
};

const closeDishModal = () => {
  showDishModal.value = false;
  selectedDish.value = null;
};

const onDishGroupUpdated = (updatedGroup) => {
  const index = dishGroups.value.findIndex(group => group.id === updatedGroup.id);
  if (index !== -1) {
    dishGroups.value[index] = updatedGroup;
  }
  closeDishGroupModal();
};

const onDishUpdated = (updatedDish) => {
  dishGroups.value.forEach(group => {
    const dishIndex = group.dishes?.findIndex(dish => dish.id === updatedDish.id);
    if (dishIndex !== -1) {
      group.dishes[dishIndex] = updatedDish;
    }
  });
  closeDishModal();
};

const onDishDeleted = (deletedDishId) => {
  dishGroups.value.forEach(group => {
    if (group.dishes) {
      group.dishes = group.dishes.filter(dish => dish.id !== deletedDishId);
    }
  });
  closeDishModal();
};

const onDishGroupDeleted = (deletedDishGroupId) => {
  dishGroups.value = dishGroups.value.filter(group => group.id !== deletedDishGroupId);
  closeDishGroupModal();
};

// Lifecycle
onMounted(async () => {
  try {
    const response = await menuResource.getDishGroups();
    dishGroups.value = response.data || [];
  } catch (error) {
    console.error('Failed to load dish groups:', error);
    dishGroups.value = [];
  }
});
</script>

<style>
:root {
  --hue-primary: 231;
  --hue-secondary: 220;
  --hue-accent: 255;
  --hue-danger: 0;

  --color-primary: hsl(var(--hue-primary), 84%, 60%);
  --color-primary-rgb: 99, 102, 241;
  --color-accent: hsl(var(--hue-accent), 70%, 55%);
  --color-text: hsl(var(--hue-secondary), 25%, 15%);
  --color-text-muted: hsl(var(--hue-secondary), 15%, 45%);
  --color-bg: hsl(var(--hue-secondary), 30%, 95%);
  --color-surface: hsl(0, 0%, 100%);
  --color-border: hsl(var(--hue-secondary), 20%, 85%);
  --color-danger: hsl(var(--hue-danger), 72%, 51%);

  --shadow-sm: 0 1px 2px 0 rgba(0,0,0,0.05);
  --shadow-md: 0 4px 6px -1px rgba(0,0,0,0.1), 0 2px 4px -2px rgba(0,0,0,0.1);
  --radius-sm: 0.375rem;
  --radius-md: 0.5rem;
  --radius-lg: 0.75rem;
  --radius-full: 9999px;
  --transition: 200ms ease-in-out;
}

@media (prefers-color-scheme: dark) {
  :root {
    --color-primary: hsl(var(--hue-primary), 70%, 65%);
    --color-accent: hsl(var(--hue-accent), 65%, 60%);
    --color-text: hsl(var(--hue-secondary), 15%, 85%);
    --color-text-muted: hsl(var(--hue-secondary), 15%, 55%);
    --color-bg: hsl(var(--hue-secondary), 15%, 15%);
    --color-surface: hsl(var(--hue-secondary), 15%, 20%);
    --color-border: hsl(var(--hue-secondary), 15%, 30%);
  }
}
</style>

<style scoped>
/* 1. THEME & GLOBAL STYLES */

/* 2. LAYOUT & STRUCTURE */
.menu-view {
  /* background-color: var(--color-bg); */
  background-color: white;
  color: var(--color-text);
  min-height: 100vh;
  display: flex;
  flex-direction: column;
}

.container {
  max-width: 1280px;
  margin-inline: auto;
  padding-inline: 1.5rem;
}

.view-header {
  position: sticky;
  top: 0;
  z-index: 20;
  background-color: hsla(0, 0%, 100%, 0.8);
  backdrop-filter: blur(8px);
  border-bottom: 0px solid var(--color-border);
  /* box-shadow: var(--shadow-sm); */
}

/*
@media (prefers-color-scheme: dark) {
  .view-header {
    background-color: hsla(var(--hue-secondary), 15%, 15%, 0.8);
  }
}*/

.header-container {
  display: flex;
  align-items: center;
  gap: 1rem;
  padding-block: 1rem;
}

.view-content {
  flex-grow: 1;
}

/* 3. HEADER COMPONENTS */
.search-bar {
  flex-grow: 1;
  position: relative;
}

.search-bar .icon {
  position: absolute;
  top: 50%;
  transform: translateY(-50%);
  left: 0.75rem;
  width: 1.25rem;
  height: 1.25rem;
  color: var(--color-text-muted);
  pointer-events: none;
}

.search-input {
  width: 100%;
  padding: 0.75rem 2.5rem;
  border: 0px solid var(--color-border);
  border-radius: 50px;
  background-color: #f1f1f1;
  color: black;
  font-size: 1rem;
  transition: var(--transition);
  transition-property: border-color, box-shadow;
}

.search-input:focus {
  outline: none;
  /* border-color: var(--color-primary);
  box-shadow: 0 0 0 3px hsla(var(--hue-primary), 84%, 60%, 0.2); */
}

.clear-btn {
  position: absolute;
  top: 50%;
  transform: translateY(-50%);
  right: 0.5rem;
  width: 1.75rem;
  height: 1.75rem;
  display: grid;
  place-items: center;
  border: none;
  background: transparent;
  color: var(--color-text-muted);
  cursor: pointer;
  border-radius: var(--radius-full);
  transition: var(--transition);
}

.clear-btn:hover {
  background-color: var(--color-border);
  color: var(--color-text);
}

.filter-toggle-btn {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  padding: 0.625rem 1.25rem;
  border: 0px solid var(--color-border);
  border-radius: 50px;
  background-color: #f1f1f1;
  color: black;
  font-weight: 500;
  cursor: pointer;
  white-space: nowrap;
  transition: var(--transition);
}
/*
.filter-toggle-btn:hover,
.filter-toggle-btn.is-active {
  background-color: rgb(0, 0, 0);
  border-color: var(--color-primary);
  color: white;
} */

.filter-toggle-btn .icon {
  width: 1.25rem;
  height: 1.25rem;
}

.filter-toggle-btn .badge {
  background-color: var(--color-accent);
  color: white;
  border-radius: var(--radius-full);
  font-size: 0.75rem;
  font-weight: 600;
  height: 1.25rem;
  min-width: 1.25rem;
  display: grid;
  place-items: center;
  padding-inline: 0.25rem;
}

.filter-toggle-btn.is-active .badge {
  background-color: white;
  color: var(--color-primary);
}

/* 4. FILTER DRAWER */
.filter-drawer {
  background-color: #f1f1f1;
  border-bottom: 1px solid var(--color-border);
  overflow-y: auto;
  max-height: 70vh;
  z-index: 10;
}

.filter-drawer > .container {
  padding-block: 1.5rem 2rem;
}

.filter-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
  gap: 1.5rem 2rem;
  padding-bottom: 2rem;
}

.filter-group {
  border: none;
  padding: 0;
  margin: 0;
  display: flex;
  flex-direction: column;
  gap: 0.75rem;
}

.filter-label {
  font-size: 0.875rem;
  font-weight: 600;
  color: var(--color-text-muted);
  text-transform: uppercase;
  letter-spacing: 0.05em;
}

.filter-range {
  display: flex;
  align-items: center;
  gap: 0.5rem;
}

.range-input {
  width: 100%;
  padding: 0.5rem 0.75rem;
  border: 0px solid var(--color-border);
  border-radius: 50px;
  background-color: white;
  color: var(--color-text);
  font-size: 0.875rem;
}

.range-input:focus {
  outline: none;
  border-color: var(--color-primary);
  box-shadow: 0 0 0 2px hsla(var(--hue-primary), 84%, 60%, 0.2);
}

.range-separator { color: var(--color-text-muted); }

.filter-options {
  display: flex;
  flex-wrap: wrap;
  gap: 0.5rem;
}

.filter-chip {
  cursor: pointer;
  display: inline-block;
  user-select: none;
}

.filter-chip input {
  /* Hide the actual checkbox */
  border: 0;
  clip: rect(0 0 0 0);
  height: 1px;
  margin: -1px;
  overflow: hidden;
  padding: 0;
  position: absolute;
  white-space: nowrap;
  width: 1px;
}

.filter-chip span {
  display: block;
  padding: 0.375rem 1rem;
  border: 0px solid var(--color-border);
  border-radius: 50px;
  background-color: white;
  color: rgb(87, 87, 87);
  font-size: 0.875rem;
  font-weight: 500;
  transition: var(--transition);
}

.filter-chip:hover span {
  border-color: var(--color-primary);
}

.filter-chip input:checked + span {
  background-color: var(--color-primary);
  border-color: var(--color-primary);
  color: white;
}

.filter-chip input:focus-visible + span {
  box-shadow: 0 0 0 3px hsla(var(--hue-primary), 84%, 60%, 0.2);
}

.filter-actions {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding-top: 1.5rem;
  margin-top: 1.5rem;
  border-top: 1px solid var(--color-border);
  gap: 1rem;
}

.results-summary {
  font-size: 0.875rem;
  font-weight: 500;
  color: var(--color-text-muted);
}

.btn-secondary {
  padding: 0.5rem 1.25rem;
  border: 1px solid var(--color-border);
  border-radius: var(--radius-md);
  background-color: transparent;
  color: var(--color-text-muted);
  font-size: 0.875rem;
  font-weight: 500;
  cursor: pointer;
  transition: var(--transition);
}

.btn-secondary:hover {
  color: var(--color-danger);
  border-color: currentColor;
}

/* 5. CONTENT AREA */
.category-section {
  margin-bottom: 3rem;
}

.category-header {
  display: flex;
  align-items: baseline;
  justify-content: space-between;
  gap: 1rem;
  padding-bottom: 0.75rem;
  margin-bottom: 1.5rem;
  border-bottom: 2px solid var(--color-border);
}

.category-title {
  font-size: 1.75rem;
  font-weight: 800;
  color: black;
  transition: color var(--transition);
}
.category-title:hover {
  color: var(--color-primary);
}

.category-count {
  background-color: hsla(var(--color-primary-rgb), 0.1);
  color: #6c6c6c;
  padding: 0.25rem 0.75rem;
  border-radius: var(--radius-full);
  font-size: 0.875rem;
  font-weight: 600;
}

.dish-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
  gap: 1.5rem;
}

.no-results-placeholder {
  text-align: center;
  padding: 4rem 1rem;
  background-color: #f1f1f1;
  border-radius: 50px;
  border: 0px solid var(--color-border);
}

.no-results-placeholder .icon-wrapper {
  display: grid;
  place-items: center;
  width: 4rem;
  height: 4rem;
  margin-inline: auto;
  margin-bottom: 1.5rem;
  background-color: white;
  border-radius: var(--radius-full);
}
.no-results-placeholder svg {
  width: 2rem;
  height: 2rem;
  color: black;
}
.no-results-placeholder h3 {
  font-size: 1.5rem;
  font-weight: 700;
  margin-bottom: 0.5rem;
  color: black;
}
.no-results-placeholder p {
  color: var(--color-text-muted);
  max-width: 40ch;
  margin-inline: auto;
}

/* 6. TRANSITIONS */
.slide-fade-enter-active,
.slide-fade-leave-active {
  transition: all 300ms ease-out;
  max-height: 1000px;
  overflow: hidden;
}
.slide-fade-enter-from,
.slide-fade-leave-to {
  opacity: 0;
  max-height: 0;
}

/* 7. RESPONSIVE DESIGN */
@media (max-width: 768px) {
  .header-container {
    flex-direction: column;
    align-items: stretch;
    gap: 0.75rem;
  }

  .filter-actions {
    flex-direction: column-reverse;
    align-items: stretch;
    text-align: center;
    gap: 1rem;
  }

  /* .category-header {
    flex-direction: column;
    align-items: flex-start;
    gap: 0.5rem;
  } */

  .dish-grid {
    grid-template-columns: 1fr;
  }

  .filter-drawer {
    max-height: 65vh;
    border-top: 1px solid var(--color-border);
    box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);
  }

  .filter-toggle-btn {
    justify-content: center;
    padding: 0.75rem;
  }

  .filter-group {
    gap: 0.5rem;
  }

  .filter-grid {
    gap: 1.25rem;
  }

  .filter-chip span {
    padding: 0.375rem 0.875rem;
    font-size: 0.8125rem;
  }

  .range-input {
    padding: 0.5rem;
  }
}

@media (max-width: 480px) {
  .container {
    padding-inline: 1rem;
  }

  .filter-grid {
    grid-template-columns: 1fr;
  }

  .search-input {
    padding: 0.75rem 2.25rem;
  }

  .category-title {
    font-size: 1.5rem;
  }

  .filter-drawer {
    max-height: 70vh;
  }

  .filter-options {
    gap: 0.375rem;
  }
}
</style>
