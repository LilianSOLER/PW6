# TP 1 – HTML/CSS, les bases

## 1 - Flukeout
- https://flukeout.github.io/
- balises HTML :
  - a - lien
  - p - paragraphe
  - div - conteneur
  - ul - liste
  - span -
- selecteur CSS :
  - .class
  - #id
  -  descendant selector 
     - a > b
  - comma combinator
    - a, b
  - universal selector
    - *
  - adjacent sibling selector
    - a + b
  - general sibling selector
    - a ~ b
  - childs selector 
    - a > b
    - :first-child
    - :only-child
    - :last-child
    - :nth-child(n)
    - :nth-last-child(n)
  - :first-of-type
  - :nth-of-type(n)
  - :nth-of-type(An+b)
  - :only-of-type
  - :last-of-type
  - :empty
  - :not(X)
  - attribute selector
    - a[href]
    - [attribute^="S"] - start
    - [for$="o"] - end
    - [for*="bb"] - contains

## 2 - Flexbox

### A- Guide to Flexbox
- https://css-tricks.com/snippets/css/a-guide-to-flexbox/
- Basics and terminology :
  - main axis
  - main-start/end
  - main size
  - cross axis
  - cross-start/end
  - cross size
- Flexbox propreties :
  - display: flex => define a flex container
  - order: n => control the order in which they appear
  - flex-direction
    - : row | row-reverse | column | column-reverse
    - establishes the main-axis
  - flex-grow: 4 => defines the ability for a flex item to grow if necessary
  - flex-wrap
    - nowrap | wrap | wrap-reverse
    - allow the items to wrap as needed
  - flex-shrink: 3 => defines the ability for a flex item to shrink
  - flex-basis : | auto => defines the default size of an element before the remaining space is distributed. It can be a length (e.g. 20%, 5rem, etc.) or a keyword.
  - flex-flow: column wrap => shorthand for the flex-direction and flex-wrap
  - justify-content
    - flex-start | flex-end | center | space-between | space-around | space-evenly | start | end | left | right ... + safe | unsafe
    - defines the alignment along the main axis
  - flex: none | [ <'flex-grow'> <'flex-shrink'>? || <'flex-basis'> ] => shorthand for flex-grow, flex-shrink and flex-basis combined.
  - align-self
    - auto | flex-start | flex-end | center | baseline | stretch
    - allows the default alignment to be overridden for individual flex items
  - align-items
    - stretch | flex-start | flex-end | center | baseline | first baseline | last baseline | start | end | self-start | self-end + ... safe | unsafe
    - defines the default behavior for how flex items are laid out along the cross axis
  - align-content
    - flex-start | flex-end | center | space-between | space-around | space-evenly | stretch | start | end | baseline | first baseline | last baseline + ... safe | unsafe
    - aligns a flex container’s lines within when there is extra space in the cross-axis, similar to how justify-content aligns individual items within the main-axis
  - gap: 10px => controls the space between flex items

### B - FLEXBOX FROGGY
- https://flexboxfroggy.com/#fr
- Solution :
  1. justify-content: flex-end => bougera la grenouille vers la droite
  2. justify-content: center
  3. justify-content : space-around
  4. justify-content: space-between
  5. align-items: flex-end => place en bas du conteneur
  6. justify-content: center; align-items: center; 
   => centre verticalement et horizontalement
  7. justify-content: space-around; align-items: flex-end;
  8. flex-direction: row-reverse
  9. flex-direction: column;
  10. flex-direction: row-reverse; justify-content: flex-end;
   => aligne les grenouilles au début en inversant l'ordre
  11. flex-direction: column; justify-content: flex-end
  12. flex-direction: column-reverse; justify-content: space-between;
  13. flex-direction: row-reverse; justify-content: center; align-items: flex-end;
   => inverse l'ordre et place en bas au centre
  14. order: 1 => place la grenouille en dernière
  15. order: -1 => place la grenouille en première
  16. align-self: flex-end
  17. order: 1; align-self: flex-end;
  18. flex-wrap: wrap
  19. flex-wrap: wrap; flex-direction: column;
  20. flex-flow : wrap column
  21. align-content: flex-start
  22. align-content: flex-end
  23. flex-direction: column-reverse; align-content: center;
  24. flex-flow:column-reverse wrap-reverse; justify-content:center; align-content:space-between;

## 3 - Exercice :

## 4 - Grid Garden :
- https://cssgridgarden.com/#fr
- Solution: 
  1. grid-column-start: 3
  2. grid-column-start: 5
  3. grid-column-end: 4
  4. grid-column-end: 2
  5. grid-column-end: 5
  6. grid-column-start: 4
  7. grid-column-end: span 2
  8. grid-column-end: span 5
  9. grid-column-start: span 3
  10. grid-column: 4/6
  11. grid-column: span 3 / 5
  12. grid-row-start: 3
  13. grid-row: 3/6
  14. grid-row: 5; grid-column: 2;
  15. grid-row: 1/6; grid-column: 2/6;
  16. grid-area: 1/2 / 4/6
  17. grid-area: 2/3 / 5/6
  18. order: 6
  19. order: -1
  20. grid-template-columns: 50% 25% 25%
  21. grid-template-columns: repeat(8, 12.5%)
  22. grid-template-columns: 100px 3em 40%
  23. grid-template-columns: 1fr 5fr
  24. grid-template-columns: 50px 1fr 1fr 1fr 50px
  25. grid-template-columns: 75px 3fr 2fr
  26. grid-template-rows: 50px 0 0 0 
  27. grid-template: 60% / 200px
  28. grid-template: 1fr 50px / 1fr 4fr

