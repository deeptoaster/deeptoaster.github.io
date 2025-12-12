import cmocean
from matplotlib.colors import Colormap

BACKGROUND_COLOR = [22, 24, 25]
STOP_COUNT = 20
ALPHA = 0.75


def print_keyframes(cmap: Colormap, name: str, property: str) -> None:
    print(f"@keyframes {name} {{")
    for stop in range(STOP_COUNT + 1):
        color = [
            round(foreground * 255) * ALPHA + background * (1 - ALPHA)
            for foreground, background in zip(
                cmap(stop / STOP_COUNT)[:3], BACKGROUND_COLOR
            )
        ]
        print(f"  {int(stop / STOP_COUNT * 100)}% {{")
        print(f"    {property}: rgb({color[0]}, {color[1]}, {color[2]});")
        print("  }")
    print("}")


cmap = cmocean.cm.cmap_d["phase"]
print_keyframes(cmap, "fishbot-ellipse", "background-color")
print_keyframes(cmap, "fishbot-region", "border-bottom-color")
